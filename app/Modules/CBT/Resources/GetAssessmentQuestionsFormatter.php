<?php

namespace App\Modules\CBT\Resources;

use App\Http\Resources\BaseResource;
use App\Modules\CBT\Models\SectionModel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Tiptap\Editor;
use Tiptap\Extensions\StarterKit;
use Tiptap\Nodes\Image;
use Tiptap\Nodes\Table;
use Tiptap\Nodes\TableCell;
use Tiptap\Nodes\TableHeader;
use Tiptap\Nodes\TableRow;

class GetAssessmentQuestionsFormatter extends JsonResource {

    protected $item;

    public function __construct($item)
    {        
        $this->item = $this->formatItem($item);
    }

    protected function formatItem($item)
    {
        return $item->groupBy('section_id')->map( function( $item ) {

                return $item->map( function($question) {

                    return [
                        'questionId'    =>  $question->questionId,
                        'prompt'        =>  $this->formatQuestion( $question->prompt ),
                        'choices'       =>  $this->formatOptions( $question->choices ),
                        'sectionId'     =>  $question->section_id,
                        'section'       =>  $question->title,
                    ];
                })->toArray();
        });
    }

    public function toArray(Request $request)
    {
        return [
            'sections'  =>  SectionModel::whereIn( 'uuid', $this->item->keys() )->get()->map( fn($section) => [ 'sectionId' => $section->uuid, 'title' => $section->title, 'description' => $section->description ]),
            'data'      =>  $this->item
        ];
    }


    protected function formatQuestion($question)
    {
        $question = json_decode($question, true);


        return ( new Editor([
            'extensions' => [
                new StarterKit(),
                new Image([
                    'HTMLAttributes' => [
                         'class' => 'rounded-lg w-auto aspect-auto border-2 mb-4',
                         'style' => 'max-height:300px; height:100%'
                    ]
                 ]),
                new Table([
                    'HTMLAttributes' => [
                         'class' => 'rounded-lg w-full'
                    ]
                 ]),
                new TableRow([
                   'HTMLAttributes' => [
                        'class' => 'rounded-lg border-2'
                   ]
                ]),
                new TableHeader([
                    'HTMLAttributes' => [
                         'class' => 'text-left rounded-lg border-2 p-2'
                    ]
                 ]),
                new TableCell([
                    'HTMLAttributes' => [
                         'class' => 'rounded-lg border-2 p-2'
                    ]
                 ])
            ]
        ]) )->setContent($question['content'])->getHTML();

    }

    protected function formatOptions($options)
    {
        $newOptions = [];

        foreach ( is_array($options) ? $options : json_decode($options, true) as $option ) {

            if($option['type'] === 'text'){
                $content = $option['content'];
                $option['htmlContent'] = "<p>$content</p>";
            }

            if($option['type'] === 'image'){

                $content = $option['content'];
                $alt = $option['alt'] ?? null;

                $option['htmlContent'] = "<img class='p-3 h-40 w-auto rounded-lg' alt='$alt' src='$content' />";
            }

            $newOptions[] = $option;
       }

       return $newOptions;
    }
}