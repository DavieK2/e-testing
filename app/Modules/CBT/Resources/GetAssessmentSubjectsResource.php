<?php

namespace App\Modules\CBT\Resources;

use App\Http\Resources\BaseResource;

class GetAssessmentSubjectsResource extends BaseResource
{
    public function toArray($request)
    {
        // dd($this->resource);
        return [
            'subjectId'     => $this->id,
            'subjectName'   => $this->subject_name,
            'classId'       => $this->pivot->class_id,
            'duration'      => $this->pivot->assessment_duration,
            'startDate'     => $this->pivot->start_date,
            'endDate'       => $this->pivot->end_date,
        ];
    }
}
