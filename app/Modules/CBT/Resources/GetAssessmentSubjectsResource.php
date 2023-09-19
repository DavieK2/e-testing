<?php

namespace App\Modules\CBT\Resources;

use App\Http\Resources\BaseResource;

class GetAssessmentSubjectsResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'subjectId'     => $this->id,
            'subjectName'   => $this->subject_name,
            'subjectCode'   => $this->subject_code,
            'classId'       => $this->pivot->class_id,
            'duration'      => ( $this->pivot->assessment_duration ) / 60,
            'startDate'     => $this->pivot->start_date,
            'endDate'       => $this->pivot->end_date,
            'published'     => $this->pivot->is_published ? 'Published' : 'Unpublished',
        ];
    }
}
