<?php

namespace App\Modules\UserManager\Tasks;

use App\Contracts\BaseTasks;
use Carbon\Carbon;
use PragmaRX\Google2FAQRCode\Google2FA;
use Exception;
use Illuminate\Validation\ValidationException;
use PragmaRX\Google2FAQRCode\QRCode\Bacon;

class TwoFactorAuthenticationTasks extends BaseTasks{

    protected Google2FA $google2FA;

    public function __construct($builder = [])
    {
        parent::__construct($builder);
        $this->google2FA = new Google2FA();
    }

    public function checkIfUserHas2FA()
    {
        $user = $this->getUser();

        if($user->has_two_factor_auth){
            return new static([ ...$this->item, 'two_factor_secret' => $user->two_factor_secret ]);
        }

        $secret = $this->google2FA->generateSecretKey();

        return new static([ ...$this->item, 'two_factor_secret' => $secret ]);
    }


    public function checkIfUser2FAHasExpired()
    {
        $user = $this->getUser();

        $two_factor_expiration = Carbon::parse($user->two_factor_expires_at)->toDateTimeString();
        
        $now = now()->toDateTimeString();

        if( (strtotime($two_factor_expiration) - strtotime($now))  > 0 ){

            return new static($this->item);
        }

        $user->update([ 'two_factor_secret' => $this->item['two_factor_secret'] ]);

        $qrCode =  ( new Google2FA(new Bacon(new \BaconQrCode\Renderer\Image\SvgImageBackEnd())) )->getQRCodeInline($user->fullname, $user->email, $user->two_factor_secret);

        return new static([ ...$this->item, 'qrCode' => $qrCode ]);

    }

    public function verifyOTP()
    {
        $user = $this->getUser();

        if( ! isset($this->item['otp']) ) throw new Exception("OTP code is required");

        $isVerified = $this->google2FA->verifyKey($user->two_factor_secret, $this->item['otp']);

        if( ! $isVerified ) throw ValidationException::withMessages(['otp' => 'Invalid OTP Provided']);

        $user->update([ 'has_two_factor_auth' => true, 'two_factor_created_at' => now(), 'two_factor_expires_at' => now()->addMonth() ]);

        return new static($this->item);


    }

    protected function getUser()
    {
        if( ! isset($this->item['user']) ) throw new Exception("2FA requires a user model");
        return $this->item['user'];
    }
    
}