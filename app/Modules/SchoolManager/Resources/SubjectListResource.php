<?php

namespace App\Modules\SchoolManager\Resources;

use App\Http\Resources\BaseResource;

class SubjectListResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'subjectId'     => $this->uuid,
            'subjectName'   => $this->subject_name,
        ];
    }
}
