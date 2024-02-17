<?php

namespace App\Modules\CBT\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetTopicRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'subjectId' => 'required|exists:subjects,uuid',
            'classId'   => 'required|exists:classes,class_code',
        ];
    }
}
