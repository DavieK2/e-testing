<?php

namespace App\Modules\SchoolManager\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateStudentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'firstName'      => 'required|string',
            'surname'       => 'required|string',
            'studentCode'   => 'nullable|string',
            'classId'       => 'required|exists:classes,uuid',
            'profilePic'     => 'nullable|string'
        ];
    }
}
