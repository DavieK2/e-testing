<?php

namespace App\Modules\CBT\Requests;

use App\Http\Requests\BaseRequest;

class EditQuestionRequest extends BaseRequest
{
    public function authorize()
    {
        return false;
    }

    public function rules()
    {
        return [
            //
        ];
    }
}
