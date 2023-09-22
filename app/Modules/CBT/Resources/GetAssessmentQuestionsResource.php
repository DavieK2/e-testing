<?php

namespace App\Modules\CBT\Resources;

use App\Http\Resources\BaseResource;

class GetAssessmentQuestionsResource extends BaseResource
{
    public function toArray($request)
    {
        $choices = json_decode($this->choices);

        $choices = collect($choices)->map( fn($choice) => trim($choice) )->toArray();

        return [
            'questionId'    => $this->questionId,
            'prompt'        => $this->prompt,
            'choices'       => $choices
        ];
    }
}
