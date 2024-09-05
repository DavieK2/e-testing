<?php

namespace App\Modules\CBT\Requests;

use App\Http\Requests\BaseRequest;

class GetQuestionBankRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'assessmentId'  => 'required|exists:assessments,uuid',
            'subjectId'     => 'required|exists:subjects,uuid'
        ];
    }
}
