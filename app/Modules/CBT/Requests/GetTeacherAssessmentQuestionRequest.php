<?php

namespace App\Modules\CBT\Requests;

use App\Http\Requests\BaseRequest;

class GetTeacherAssessmentQuestionRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'classId'       => 'required|exists:classes,class_code',
            'subjectId'     => 'required|exists:subjects,uuid',
            'assessmentId'  => 'required|exists:assessments,uuid',
        ];
    }
}
