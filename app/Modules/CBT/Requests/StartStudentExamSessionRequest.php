<?php

namespace App\Modules\CBT\Requests;

use App\Http\Requests\BaseRequest;

class StartStudentExamSessionRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            
        ];
    }
}
