<?php

namespace App\Modules\CBT\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AssessmentListCollection extends ResourceCollection
{
    public $collects = AssessmentListResource::class;
    
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
