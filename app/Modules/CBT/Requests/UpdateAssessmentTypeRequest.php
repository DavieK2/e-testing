<?php

namespace App\Modules\CBT\Requests;

use App\Http\Requests\BaseRequest;

class UpdateAssessmentTypeRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'assessmentType' => 'nullable',
            'maxScore' => 'nullable'
        ];
    }
}
