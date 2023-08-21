<?php

namespace App\Modules\UserManager\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TwoFactorAuthenticationOTPRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'otp' => 'required|string'
        ];
    }
}
