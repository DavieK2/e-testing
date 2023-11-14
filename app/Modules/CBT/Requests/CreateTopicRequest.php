<?php

namespace App\Modules\CBT\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTopicRequest extends FormRequest
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
            'subjectId' => 'required|exists:subjects,id',
            'classes.*' => 'exists:classes,class_code'
        ];
    }
}
