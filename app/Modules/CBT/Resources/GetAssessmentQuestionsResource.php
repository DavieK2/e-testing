<?php

namespace App\Modules\CBT\Resources;

use App\Http\Resources\BaseResource;
use Illuminate\Support\Facades\Log;
use Tiptap\Editor;
use Tiptap\Extensions\StarterKit;
use Tiptap\Nodes\Image;
use Tiptap\Nodes\Table;
use Tiptap\Nodes\TableCell;
use Tiptap\Nodes\TableHeader;
use Tiptap\Nodes\TableRow;

class GetAssessmentQuestionsResource extends BaseResource
{
    public function toArray($request)
    { 
        
        $question = json_decode($this->prompt, true);
        $options = [];

        $question = ( new Editor([
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


        foreach ( is_array($this->choices) ? $this->choices : json_decode($this->choices, true) as $option ) {

            if($option['type'] === 'text'){
                $content = $option['content'];
                $option['htmlContent'] = "<p>$content</p>";
            }

            if($option['type'] === 'image'){

                $content = $option['content'];
                $alt = $option['alt'] ?? null;

                $option['htmlContent'] = "<img class='p-3 h-40 w-auto rounded-lg' alt='$alt' src='$content' />";
            }

            $options[] = $option;
       }

        return [
            'questionId'    => $this->questionId,
            'prompt'        => $question,
            'choices'       => $options
        ];
    }
}
