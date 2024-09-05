<?php

namespace App\Modules\CBT\Requests;

use App\Http\Requests\BaseRequest;

class CreateTopicRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {        
        return [
            'title'     => 'required|string',
            'classes'   => 'required|array',
            'subjectId' => 'required|exists:subjects,uuid',
            'classes.*' => 'exists:classes,class_code'
        ];
    }
}
