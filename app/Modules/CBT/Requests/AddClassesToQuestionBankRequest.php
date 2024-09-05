<?php

namespace App\Modules\CBT\Requests;

use App\Http\Requests\BaseRequest;

class AddClassesToQuestionBankRequest extends BaseRequest
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
