<?php

namespace App\Modules\CBT\Resources;

use App\Http\Resources\BaseResource;

class GetAssessmentQuestionsResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'questionId'    => $this->questionId,
            'prompt'        => $this->prompt,
            'choices'       => json_decode($this->choices)
        ];
    }
}
