<?php

namespace App\Modules\CBT\Requests;

use App\Http\Requests\BaseRequest;

class PublishTermlyAssessmentRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'assessmentId'  => 'required|exists:assessments,uuid',
            'subjectId'     => 'required|exists:subjects,uuid',
            'classId'       => 'required|exists:classes,class_code',
            'shouldPublish' => 'required'
        ];
    }
}
