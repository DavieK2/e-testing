<?php

namespace App\Modules\CBT\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetAssessmentQuestionSectionRequest extends FormRequest
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
        ];
    }
}
