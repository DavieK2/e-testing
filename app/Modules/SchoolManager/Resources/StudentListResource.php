<?php

namespace App\Modules\SchoolManager\Resources;

use App\Http\Resources\BaseResource;
use App\Modules\SchoolManager\Models\ClassModel;

class StudentListResource extends BaseResource
{
    public function __construct(protected $item, protected bool $more_student_info = false){
        parent::__construct($item);
    }

    public function toArray($request)
    {
        $data =  [
            'studentId'     => $this->item->uuid,
            'name'          => $this->item->first_name. " ". $this->item->surname,
            'classId'       => $this->item->class_id,
            'class'         => ClassModel::find($this->item->class_id)?->class_name,
           
        ];

        if( $this->more_student_info ){

            $data = [
                'studentCode'   => $this->item->student_code,
                'firstName'      => $this->item->first_name,
                'surname'       => $this->item->surname,
                'photo'         => $this->item->profile_pic,
                ...$data 
            ];
        }

        return $data;
    }
}
