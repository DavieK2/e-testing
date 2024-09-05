<?php

namespace App\Modules\SchoolManager\Requests;

use App\Http\Requests\BaseRequest;

class MassAssignSubjectsToStudentsRequest extends BaseRequest
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
