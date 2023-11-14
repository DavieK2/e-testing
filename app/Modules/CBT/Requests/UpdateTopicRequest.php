<?php

namespace App\Modules\CBT\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTopicRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'topicId'               => 'required|exists:topics,uuid',
            'title'                 => 'required|string',
            'classes'               => 'required|array',
            'subjectId'             => 'required|exists:subjects,id',
            'classes.*.classCode'   => 'required|exists:classes,class_code',
            'classes.*.classId'     => 'nullable',
        ];
    }
}
