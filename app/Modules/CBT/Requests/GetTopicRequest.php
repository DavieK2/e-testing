<?php

namespace App\Modules\CBT\Requests;

use App\Http\Requests\BaseRequest;

class GetTopicRequest extends BaseRequest
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
