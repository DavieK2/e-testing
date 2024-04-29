<?php

namespace App\Modules\CBT\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GetAssessmentQuestionsCollection extends ResourceCollection
{
    public $collects = GetAssessmentQuestionsResource::class;
    
    public function toArray($request)
    {
        // $data = $this->resource->groupBy('section_id');

        // dd( $data );
        return parent::toArray($request);
    }
}
