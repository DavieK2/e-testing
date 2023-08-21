<?php

namespace App\Modules\CBT\Resources;

use App\Http\Resources\BaseResource;
use Carbon\Carbon;

class AssessmentListResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'assessmentId' => $this->uuid,
            'isStandalone' => $this->is_standalone ? 'Standalone' : 'Termly',
            'title' => $this->title,
            'assessmentType' => $this->type,
            'session' => $this->session ? $this->session : '',
            'status' => $this->is_published ? 'Published' : 'Unpublished',
            'term' => $this->term ? $this->term : '',
            'startDate' => Carbon::parse($this->start_date)->format('D, M d Y h:i A'),
            'endDate' => Carbon::parse($this->end_date)->format('D, M d Y h:i A'),
            'description' => $this->description,
            'duration' => $this->assessment_duration,
            'assessmentLink' => url("/cbt/".$this->uuid)
        ];
    }
}
