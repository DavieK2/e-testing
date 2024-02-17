<?php

namespace App\Modules\SchoolManager\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignSubjectToStudentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'studentId' => 'required|exists:student_profiles,uuid',
            'subjects'  => 'required|array',
            'subjects.*.subjectId' => 'required|exists:subjects,uuid'
        ];
    }
}
