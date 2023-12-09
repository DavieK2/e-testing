<?php

namespace App\Modules\CBT\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MassAssignUnQuestionsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {       
        return [
            'questions'     => 'required|array',
            'questions.*'   => 'exists:questions,uuid'
        ];
    }
}
