<?php

namespace App\Modules\CBT\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuestionListRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'questionBankId'    =>  ['exists:question_banks,uuid'],
            'assessmentId'      =>  [ Rule::requiredIf( is_null( request('questionBankId') ) ), 'exists:assessments,uuid'],
            'subjectId'         =>  [ Rule::requiredIf( request('assigned') == true ) , 'exists:subjects,uuid'],
            'classId'           =>  [ Rule::requiredIf( request('assigned') == true ), 'exists:classes,class_code'],
            'assigned'          =>  'boolean',
            'filter'             =>  'json',
            'perPage'           =>  'required|int',
        ];
    }
}
