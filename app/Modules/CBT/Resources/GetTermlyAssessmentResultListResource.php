<?php

namespace App\Modules\CBT\Resources;

use App\Http\Resources\BaseResource;

class GetTermlyAssessmentResultListResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'studentName'   => $this->first_name." ".$this->surname,
            'studentId'     => $this->id,
            'class'         => strtoupper($this->class_name),
            'subject'       => strtoupper("$this->subject_name ($this->subject_code)"),
            'score'         => $this->total_score,
            'grade'         => $this->grade
        ];
    }
}
