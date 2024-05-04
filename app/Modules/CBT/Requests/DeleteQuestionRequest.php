<?php

namespace App\Modules\CBT\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteQuestionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'questionIds'   => 'required|array',
            'assessmentId'  => 'required|exists:assessments,uuid'
        ];
    }
}
