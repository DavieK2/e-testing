<?php

namespace App\Modules\CBT\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionBankRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'assessmentId' =>  'exists:assessments,uuid',
            'filter'        =>  'json',
            'perPage'      =>  'required|int',
        ];
    }
}
