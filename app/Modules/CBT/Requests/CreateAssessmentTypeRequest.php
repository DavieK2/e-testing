<?php

namespace App\Modules\CBT\Requests;

use App\Http\Requests\BaseRequest;

class CreateAssessmentTypeRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'assessmentType'    => 'required',
            'maxScore'          => 'required'
        ];
    }
}
