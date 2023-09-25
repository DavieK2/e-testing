<?php

namespace App\Modules\CBT\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GetTermlyAssessmentResultListCollection extends ResourceCollection
{

    public $collects = GetTermlyAssessmentResultListResource::class;

    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
