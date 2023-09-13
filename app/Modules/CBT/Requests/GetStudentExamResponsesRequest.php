<?php

namespace App\Modules\CBT\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetStudentExamResponsesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'subjectId' => [ Rule::requiredIf( ! $this->route('assessment')->is_standalone ), 'exists:subjects,subject_code' ],
        ];
    }
}
