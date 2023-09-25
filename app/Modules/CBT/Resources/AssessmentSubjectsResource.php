<?php

namespace App\Modules\CBT\Resources;

use App\Http\Resources\BaseResource;

class AssessmentSubjectsResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'subjectId' => $this->id,
            'subjectName' => $this->subject_name,
            'subjectCode' => $this->subject_code
        ];
    }
}
