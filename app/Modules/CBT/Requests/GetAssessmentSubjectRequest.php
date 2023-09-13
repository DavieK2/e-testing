<?php

namespace App\Modules\CBT\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetAssessmentSubjectRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'classId' => 'exists:classes,id'
        ];
    }
}
