<?php

namespace App\Modules\CBT\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentLoginRequest extends FormRequest
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
