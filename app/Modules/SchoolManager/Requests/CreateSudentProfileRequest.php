<?php

namespace App\Modules\SchoolManager\Requests;

use App\Http\Requests\BaseRequest;

class CreateSudentProfileRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'firstName' => 'required',
            'lastName' => 'required',
            'regNo' => 'required',
            'profilePic' => 'required',
            'level' => 'required',
            'session' => 'required',
            'phoneNo' => 'nullable',
            'programOfStudy' => 'nullable',
            'email' => 'nullable',
        ];
    }
}
