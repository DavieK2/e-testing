<?php

namespace App\Modules\CBT\Requests;

use App\Http\Requests\BaseRequest;

class GetAssessmentSubjectRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'classId' => 'exists:classes,uuid'
        ];
    }
}
