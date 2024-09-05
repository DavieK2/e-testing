<?php

namespace App\Modules\CBT\Requests;

use App\Http\Requests\BaseRequest;

class DownloadQuestionsRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'questions'     => 'required|array',
            'questions.*'   => 'required',
        ];
    }
}
