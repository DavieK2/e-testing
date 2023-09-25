<?php

namespace App\Modules\CBT\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AssessmentSubjectsCollection extends ResourceCollection
{
    public $collects = AssessmentSubjectsResource::class;

    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
