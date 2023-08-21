<?php

namespace App\Modules\CBT\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAssessmentTypeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'assessmentTypeId' => 'required|exists:assessment_types,id',
            'assessmentType' => 'nullable',
            'maxScore' => 'nullable'
        ];
    }
}
