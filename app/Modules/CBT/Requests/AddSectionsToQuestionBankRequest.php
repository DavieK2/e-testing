<?php

namespace App\Modules\CBT\Requests;

use App\Http\Requests\BaseRequest;

class AddSectionsToQuestionBankRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'questionBankId'    => 'exists:question_banks,uuid',
        ];
    }
}
