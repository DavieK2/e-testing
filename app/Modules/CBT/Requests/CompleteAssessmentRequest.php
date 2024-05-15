<?php

namespace App\Modules\CBT\Requests;

use App\Http\Requests\BaseRequest;


class CompleteAssessmentRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'step'                      => 'required|in:create_assessment,add_classes,complete_assessment',
            'assessmentId'              => 'required|exists:assessments,uuid',
            'subjects'                  => 'required|array',
            'subjects.*.*.subjectId'    => 'required',
            'subjects.*.*.id'           => 'nullable',
            'subjects.*.*.classId'      => 'required',
            'subjects.*.*.duration'     => 'required',
            'subjects.*.*.startDate'    => 'required',
            'subjects.*.*.endDate'      => 'required',
            'subjects.*.*.published'    => 'required',
        ];
    }
}
