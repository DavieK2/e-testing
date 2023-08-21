<?php

namespace App\Modules\CBT\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionListResource extends JsonResource
{
    
    public function toArray($request)
    {
        return [
            'questionId'    => $this->uuid,
            'question'      => $this->question,
            'correctAnswer' => $this->correct_answer,
            'options'       => ! is_array($this->options) ? json_decode($this->options) : $this->options,
            'source'        => $request->assigned ? 'assigned' : 'assessment',
            'questionScore' => $this->question_score,
        ];
    }
}
