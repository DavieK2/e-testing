<?php

namespace App\Modules\SchoolManager\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ClassListCollection extends ResourceCollection
{
    public $collects = ClassListResource::class;
    
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
