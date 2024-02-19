<?php

namespace App\Modules\SchoolManager\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MassAssignSubjectsToStudentsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'subjects'      => 'array',
            'students'      => 'array',
            'subjects.*'    => 'exists:subjects,uuid',
            'students.*'    => 'exists:student_profiles,uuid',
        ];
    }
}
