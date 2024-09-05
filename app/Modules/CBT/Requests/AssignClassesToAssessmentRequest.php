<?php

namespace App\Modules\CBT\Requests;

use App\Http\Requests\BaseRequest;

class AssignClassesToAssessmentRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'step'          => 'required|in:create_assessment,add_classes,complete_assessment',
            'assessmentId'  => 'required|exists:assessments,uuid',
            'classes'       => 'required'
        ];
    }
}
