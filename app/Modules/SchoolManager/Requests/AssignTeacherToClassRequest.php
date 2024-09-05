<?php

namespace App\Modules\SchoolManager\Requests;

use App\Http\Requests\BaseRequest;

class AssignTeacherToClassRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'classes'    => 'required|array',
            'classes.*'  => 'required|exists:classes,uuid',
        ];
    }
}
