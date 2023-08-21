<?php

namespace App\Modules\CBT\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GetAssessmentSubjectsCollection extends ResourceCollection
{
    public $collects = GetAssessmentSubjectsResource::class;
    
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
