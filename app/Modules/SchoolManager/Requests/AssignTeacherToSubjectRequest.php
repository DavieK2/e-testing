<?php

namespace App\Modules\SchoolManager\Requests;

use App\Http\Requests\BaseRequest;

class AssignTeacherToSubjectRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'subjects'    => 'required|array',
            'subjects.*'  => 'required|exists:subjects,uuid',
        ];
    }
}
