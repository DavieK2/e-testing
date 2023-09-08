<?php

namespace App\Modules\SchoolManager\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SubjectListCollection extends ResourceCollection
{
    public $collects = SubjectListResource::class;

    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
