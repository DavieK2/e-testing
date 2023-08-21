<?php

namespace App\Modules\CBT\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GetAssessmentQuestionsCollection extends ResourceCollection
{
    public $collects = GetAssessmentQuestionsResource::class;
    
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
