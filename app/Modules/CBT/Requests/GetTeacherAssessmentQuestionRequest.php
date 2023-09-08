<?php

namespace App\Modules\CBT\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetTeacherAssessmentQuestionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'classId'       => 'required|exists:classes,class_code',
            'subjectId'     => 'required|exists:subjects,id',
            'assessmentId'  => 'required|exists:assessments,uuid',
        ];
    }
}
