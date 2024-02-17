<?php

namespace App\Modules\CBT\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateQuestionBankRequest extends FormRequest
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
            'classes'       => [ 'array', Rule::requiredIf( request()->user()->is_admin ) , Rule::prohibitedIf( request()->user()->is_teacher) ],
            'classes.*'     => 'exists:classes,class_code'
        ];
    }
}
