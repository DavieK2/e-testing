<?php

namespace App\Modules\UserManager\Requests;

use App\Http\Requests\BaseRequest;

class TwoFactorAuthenticationOTPRequest extends BaseRequest
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
