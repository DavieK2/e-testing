<?php

namespace App\Modules\CBT\Requests;

use App\Http\Requests\BaseRequest;

class DeleteQuestionRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'questionIds'   => 'required|array',
            'questionIds.*' => 'exists:questions,uuid',
            'assessmentId'  => 'required|exists:assessments,uuid'
        ];
    }
}
