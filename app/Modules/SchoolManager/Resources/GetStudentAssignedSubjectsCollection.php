<?php

namespace App\Modules\SchoolManager\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GetStudentAssignedSubjectsCollection extends ResourceCollection
{
    public $collects = GetStudentAssignedSubjectsResource::class;
    
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
