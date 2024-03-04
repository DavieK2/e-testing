<?php

namespace App\Modules\CBT\Resources;

use App\Services\ArrayToHTML;
use Illuminate\Http\Resources\Json\JsonResource;
use Tiptap\Editor;
use Tiptap\Extensions\StarterKit;
use Tiptap\Nodes\Image;
use Tiptap\Nodes\Table;
use Tiptap\Nodes\TableCell;
use Tiptap\Nodes\TableHeader;
use Tiptap\Nodes\TableRow;

class QuestionListResource extends JsonResource
{
    
    public function toArray($request)
    {
        $question = json_decode($this->question, true);
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

        // dd($h);

        // foreach ($contents as $key => $content) {

        //     if( $content['type'] === 'paragraph' ){

        //         $text = $content['content'][0]['text'] ?? '';

        //         if( empty($text) ){

        //             $questionHTML .= "<p class='py-2'></p>";
        //         }else{

        //             $questionHTML .= "<p>$text</p>";
        //         }
                
        //     }

        //     if( $content['type'] === 'table' ){

        //         $html = new ArrayToHTML();

        //         $html->rootTag('table', ['class' => 'w-full rounded-lg']);

        //         foreach( $content['content'] as $tablekey => $table){

        //             if( $table['type'] === 'tableRow' ){

        //                 $html->appendToRootTag('tr');

        //                 foreach ( $table['content'] as $tableRowKey => $tableRow ) {
                            
        //                     foreach ( $tableRow['content'] as $tableDataKey => $tableData ) {
                                
        //                         if( $tableData['type'] === 'paragraph' ){

        //                             $text = $tableData['content'][0]['text'] ?? '';

        //                             $html->appendToElement('tr', 'td', key: $tablekey, attributes: ['class' => 'border-2']);
        //                             // $html->appendToElement('td', 'p', content: $text, key: $tableRowKey);
        //                         }

        //                         if( $tableData['type'] === 'image' ){

        //                             $img = $tableData['attrs']['src'];
        //                             $alt = $tableData['attrs']['alt'] ?? null;


        //                             $html->appendToElement('tr', 'td', key: $tablekey, attributes: ['class' => 'border-2']);

        //                             // $html->appendToElement('td', 'img', key: $tableRowKey, attributes: ['src' => $img, 'alt' => $alt ]);
        //                         }
        //                     }

        //                 }
                        
        //             }
                    
        //         }
                            
        //         $questionHTML .= $html->getContent();
        //     }

        //     if( $content['type'] === 'image' ){

        //         $img = $content['attrs']['src'];
        //         $alt = $content['attrs']['alt'] ?? null;

        //         $questionHTML .= "<img class='rounded-lg h-60 w-auto py-3' alt='$alt' src='$img' />";
        //     }
        // }

       foreach ( is_array($this->options) ? $this->options : json_decode($this->options, true) as $option ) {

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
            'questionId'        => $this->uuid,
            'questionBankId'    => $this->question_bank_id,
            'question'          => $question,
            'correctAnswer'     => $this->correct_answer,
            'options'           => $options,
            'source'            => $request->assigned ? 'assigned' : 'assessment',
            'questionScore'     => $this->question_score,
            'questionType'      => $this->question_type,
            // 'assessmentId'  => $this->assessmentId,
            'topicId'           => $this->topicId,
            'sectionId'         => $this->sectionId ?? 'No Section',
            'sectionTitle'      => $this->sectionTitle ?? 'No Section',
            'isVisible'         => true,
            'isAssigned'        => isset($this->isAssigned) ? $this->isAssigned : ($this->assessment_id == request('assessmentId') ? 'Assigned' : 'Not Assigned')
        ];
    }
}
