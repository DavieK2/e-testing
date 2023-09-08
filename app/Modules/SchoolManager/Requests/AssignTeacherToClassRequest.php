<?php

namespace App\Modules\SchoolManager\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignTeacherToClassRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'teacherId' => 'required|exists:users,id',
            'classes'  => 'required|array',
            'classes.*.id' => 'required|exists:classes,id',
        ];
    }
}
