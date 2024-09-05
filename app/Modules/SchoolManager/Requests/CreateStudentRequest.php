<?php

namespace App\Modules\SchoolManager\Requests;

use App\Http\Requests\BaseRequest;

class CreateStudentRequest extends BaseRequest
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
