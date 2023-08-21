<?php

namespace App\Modules\CBT\Resources;

use App\Http\Resources\BaseResource;

class QuestionBankResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'questionId'    => $this->uuid,
            'question'      => $this->question,
            'correctAnswer' => $this->correct_answer,
            'options'       => ! is_array($this->options) ? json_decode($this->options) : $this->options,
            'source'        => 'questionBank',
            'questionScore' => $this->question_score,
        ];
    }
}
