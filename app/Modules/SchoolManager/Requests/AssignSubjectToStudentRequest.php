<?php

namespace App\Modules\SchoolManager\Requests;

use App\Http\Requests\BaseRequest;

class AssignSubjectToStudentRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'subjects'      => 'required|array',
            'subjects.*'    => 'required|exists:subjects,uuid'
        ];
    }
}
