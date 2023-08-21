<?php

namespace App\Modules\UserManager\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\UserManager\Features\LoginFeature;
use App\Modules\UserManager\Features\TwoFactorAuthenticationFeature;
use App\Modules\UserManager\Requests\LoginRequest;
use App\Modules\UserManager\Requests\TwoFactorAuthenticationOTPRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        return $this->serve(new LoginFeature(), $request->validated());
    }

    public function  get2FA()
    {
        return $this->serve(new TwoFactorAuthenticationFeature(request()->user()));
    }

    public function verify2FA(TwoFactorAuthenticationOTPRequest $request)
    {
        return $this->serve(new TwoFactorAuthenticationFeature(request()->user()), $request->validated() );
    }
}
