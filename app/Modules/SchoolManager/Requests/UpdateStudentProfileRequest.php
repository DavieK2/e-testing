<?php

namespace App\Modules\SchoolManager\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'studentId'     => 'required|exists:student_profiles,uuid',
            'firstName'      => 'required|string',
            'surname'       => 'required|string',
            'classId'       => 'required|exists:classes,uuid',
            'profilePic'     => 'nullable|string'
        ];
    }
}
