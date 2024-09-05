<?php

namespace App\Modules\UserManager\Requests;

use App\Http\Requests\BaseRequest;

class LoginRequest extends BaseRequest
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
