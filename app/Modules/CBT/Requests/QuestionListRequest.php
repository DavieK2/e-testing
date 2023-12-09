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
            'assessmentId'      =>  ['exists:assessments,uuid'],
            'assigned'          =>  'boolean',
            'filter'             =>  'json',
            'perPage'           =>  'required|int',
        ];
    }
}
