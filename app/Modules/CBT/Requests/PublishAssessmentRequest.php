<?php

namespace App\Modules\CBT\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PublishAssessmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'assessmentId' => 'required|exists:assessments,uuid',
            'publish' => 'boolean'
        ];
    }
}
