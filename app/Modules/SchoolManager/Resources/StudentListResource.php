<?php

namespace App\Modules\SchoolManager\Resources;

use App\Http\Resources\BaseResource;

class StudentListResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'studentId'     => $this->id,
            'studentCode'   => $this->student_code,
            'name'          => $this->first_name. " ". $this->surname,
            'firstName'      => $this->first_name,
            'surname'       => $this->surname,
            'classId'       => $this->class_id,
            'class'         => $this->class?->class_name,
            'photo'         => $this->profile_pic
        ];
    }
}
