<?php

namespace App\Modules\SchoolManager\Requests;

use App\Http\Requests\BaseRequest;

class AssignSubjectToClassRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'subjects'      => 'required|array',
            'subjects.*'    => 'exists:subjects,uuid'
        ];
    }
}
