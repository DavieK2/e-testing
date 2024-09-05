<?php

namespace App\Modules\CBT\Requests;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class UpdateQuestionBankClassesRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'questionBankId'    => 'required|exists:question_banks,uuid',
            'classes'           => [ 'array', Rule::requiredIf( request()->user()->is_admin ) , Rule::prohibitedIf( request()->user()->is_teacher) ],
            'classes.*'         => 'exists:classes,class_code'
        ];
    }
}
