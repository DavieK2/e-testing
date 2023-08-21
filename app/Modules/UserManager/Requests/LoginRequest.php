<?php

namespace App\Modules\UserManager\Requests;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // dd(request()->all());
        return [
            'email' => 'required|email',
            'password' => 'required'
        ];
    }
}
