<?php

namespace App\Modules\SchoolManager\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class StudentListCollection extends ResourceCollection
{
    public $collects = StudentListResource::class;
    
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
