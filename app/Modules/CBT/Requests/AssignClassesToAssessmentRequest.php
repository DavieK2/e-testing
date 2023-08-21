<?php

namespace App\Modules\CBT\Requests;

use App\Modules\CBT\Constants\CBTConstants;
use Illuminate\Foundation\Http\FormRequest;

class AssignClassesToAssessmentRequest extends FormRequest
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
