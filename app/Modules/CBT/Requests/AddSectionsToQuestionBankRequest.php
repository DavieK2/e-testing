<?php

namespace App\Modules\CBT\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddSectionsToQuestionBankRequest extends FormRequest
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
