<?php

namespace App\Modules\CBT\Requests;

use App\Http\Requests\BaseRequest;

class UpdateTopicRequest extends BaseRequest
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
            'subjectId'             => 'required|exists:subjects,uuid',
            'classes.*.classCode'   => 'required|exists:classes,class_code',
            'classes.*.classId'     => 'nullable',
        ];
    }
}
