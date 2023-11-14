<?php

namespace App\Modules\CBT\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddClassesToQuestionBankRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'questionBankId'    => 'required|exists:question_banks,uuid',
            'classes'           => 'required|array',
            'classes.*'         => 'exists:classes,class_code'
        ];
    }
}
