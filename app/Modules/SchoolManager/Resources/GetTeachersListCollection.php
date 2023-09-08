<?php

namespace App\Modules\SchoolManager\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GetTeachersListCollection extends ResourceCollection
{

    public $collects = GetTeachersListResource::class;

    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
