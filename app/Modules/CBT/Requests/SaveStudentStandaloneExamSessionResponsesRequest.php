<?php

namespace App\Modules\CBT\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveStudentStandaloneExamSessionResponsesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'questionId' => 'required|exists:questions,uuid',
            'studentAnswer' => 'nullable',
            'markedForReview' => 'required',
        ];
    }
}
