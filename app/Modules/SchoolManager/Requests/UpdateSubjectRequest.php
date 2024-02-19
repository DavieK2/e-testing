<?php

namespace App\Modules\SchoolManager\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubjectRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'subjectId'     => 'required|exists:subjects,uuid',
            'subjectName'   => 'required',
            'subjectCode'   => 'nullable'
        ];
    }
}
