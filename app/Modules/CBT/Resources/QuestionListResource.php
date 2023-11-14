<?php

namespace App\Modules\CBT\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Tiptap\Editor;

class QuestionListResource extends JsonResource
{
    
    public function toArray($request)
    {
        $questionHTML = '';
        $question = json_decode($this->question, true);

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
                $questionHTML .= "<img class='rounded-lg h-60 w-auto py-3' src='/$img' />";
            }
        }

        return [
            'questionId'    => $this->uuid,
            'question'      => $questionHTML,
            'correctAnswer' => $this->correct_answer,
            'options'       => ! is_array($this->options) ? json_decode($this->options) : $this->options,
            'source'        => $request->assigned ? 'assigned' : 'assessment',
            'questionScore' => $this->question_score,
            'assessmentId'  => $this->assessmentId,
        ];
    }
}
