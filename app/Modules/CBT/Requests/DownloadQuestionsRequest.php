<?php

namespace App\Modules\CBT\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DownloadQuestionsRequest extends FormRequest
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
