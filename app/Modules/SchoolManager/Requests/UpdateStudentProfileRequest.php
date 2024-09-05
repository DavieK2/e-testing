<?php

namespace App\Modules\SchoolManager\Requests;

use App\Http\Requests\BaseRequest;

class UpdateStudentProfileRequest extends BaseRequest
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
            'classId'       => 'required|exists:classes,uuid',
            'studentCode'   => 'nullable|string',
            'profilePic'     => 'nullable|string'
        ];
    }
}
