<?php

namespace App\Modules\CBT\Resources;

use App\Http\Resources\BaseResource;

class GetAssessmentSubjectsResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'subjectId'     => $this->uuid,
            'subjectName'   => $this->subject_name,
            'subjectCode'   => $this->subject_code,
            'classId'       => $this->class_id,
            'duration'      => ( $this->assessment_duration ) / 60,
            'startDate'     => $this->start_date,
            'endDate'       => $this->end_date,
            'published'     => $this->is_published ? 'Published' : 'Unpublished',
        ];
    }
}
