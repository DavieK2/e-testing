<?php

namespace App\Modules\CBT\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Tiptap\Editor;

class QuestionListResource extends JsonResource
{
    
    public function toArray($request)
    {
        $question = json_decode($this->question, true);

        dd($question);

        return [
            'questionId'    => $this->uuid,
            'question'      => $this->question,
            'correctAnswer' => $this->correct_answer,
            'options'       => ! is_array($this->options) ? json_decode($this->options) : $this->options,
            'source'        => $request->assigned ? 'assigned' : 'assessment',
            'questionScore' => $this->question_score,
            'assessmentId'  => $this->assessmentId,
        ];
    }
}
