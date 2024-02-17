<?php

namespace App\Modules\SchoolManager\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignTeacherToSubjectRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'teacherId'             => 'required|exists:users,uuid',
            'subjects'              => 'required|array',
            'subjects.*.subjectId'  => 'required|exists:subjects,uuid',
        ];
    }
}
