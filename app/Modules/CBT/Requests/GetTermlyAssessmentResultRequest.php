<?php

namespace App\Modules\CBT\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetTermlyAssessmentResultRequest extends FormRequest
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
            'classId'       => 'required|exists:classes,uuid',
        ];
    }
}
