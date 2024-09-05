<?php

namespace App\Modules\CBT\Requests;

use App\Http\Requests\BaseRequest;

class StudentLoginRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'studentCode' => 'required'
        ];
    }
}
