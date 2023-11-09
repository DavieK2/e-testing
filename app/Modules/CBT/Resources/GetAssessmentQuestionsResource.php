<?php

namespace App\Modules\CBT\Resources;

use App\Http\Resources\BaseResource;
use Illuminate\Support\Facades\Log;

class GetAssessmentQuestionsResource extends BaseResource
{
    public function toArray($request)
    {
        $choices = json_decode($this->choices);

        try {

            $choices = collect($choices)->map( fn($choice) => trim($choice) )->toArray();

        } catch (\Throwable $th) {
           
            Log::error($th);
        }


        return [
            'questionId'    => $this->questionId,
            'prompt'        => $this->prompt,
            'choices'       => $choices
        ];
    }
}
