<?php

namespace App\Modules\CBT\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionListResource extends JsonResource
{
    
    public function toArray($request)
    {
        $questionHTML = '';
        $question = json_decode($this->question, true);
        $options = [];

        $contents = $question['content']['content'];

        foreach ($contents as $key => $content) {

            if( $content['type'] === 'paragraph' ){
                $text = $content['content'][0]['text'] ?? '';
                if( empty($text) ){
                    $questionHTML .= "<p class='py-2'></p>";
                }else{
                    $questionHTML .= "<p>$text</p>";
                }
                
            }

            if( $content['type'] === 'image' ){

                $img = $content['attrs']['src'];
                $alt = $content['attrs']['alt'] ?? null;

                $questionHTML .= "<img class='rounded-lg h-60 w-auto py-3' alt='$alt' src='$img' />";
            }
        }

       foreach ( $this->options as $option ) {

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
            'questionId'    => $this->uuid,
            'question'      => $questionHTML,
            'correctAnswer' => $this->correct_answer,
            'options'       => $options,
            'source'        => $request->assigned ? 'assigned' : 'assessment',
            'questionScore' => $this->question_score,
            'assessmentId'  => $this->assessmentId,
            'topicId'       => $this->topicId,
            'sectionId'     => $this->sectionId,
        ];
    }
}
