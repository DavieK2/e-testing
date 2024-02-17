<?php

namespace App\Modules\SchoolManager\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignSubjectToClassRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'classId'   => 'required|exists:classes,uuid',
            'subjects'  => 'required|array'
        ];
    }
}
