<?php

namespace App\Modules\CBT\Resources;

use App\Http\Resources\BaseResource;

class GetAssessmentResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'assessment' => [
                'title'             => $this->title,
                'assessmentTypeId'  => $this->assessment_type_id,
                'assessmentType'    => $this->assessmentType?->type,
                'academicSessionId' => $this->academic_session_id,
                'academicSession'   => $this->session?->session,
                'description'       => $this->description,
                'termId'            => $this->school_term_id,
                'term'              => $this->term?->term,
                'isStandalone'      => $this->is_standalone,
                'duration'          => $this->assessment_duration,
                'startDate'         => $this->start_date,
                'endDate'           => $this->end_date,
            ]
        ];
    }
}
