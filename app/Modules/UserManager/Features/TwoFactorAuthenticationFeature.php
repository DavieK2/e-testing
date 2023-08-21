<?php

namespace App\Modules\UserManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\UserManager\Models\UserModel;
use App\Modules\UserManager\Tasks\TwoFactorAuthenticationTasks;
use Illuminate\Validation\ValidationException;

class TwoFactorAuthenticationFeature extends FeatureContract {

    public function __construct(protected UserModel $user){
        $this->tasks = new TwoFactorAuthenticationTasks();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
       try {

            if( isset($args['otp']) ){

                $builder = $task->start([ ...$args, 'user' => $this->user ])->verifyOTP();
                return $task::formatResponse( $builder->empty(), options: ['message' => 'OTP Successfully Verified'] );

            }

            $builder = $task->start([ 'user' => $this->user ])->checkIfUserHas2FA()->checkIfUser2FAHasExpired();
            
            return $task::formatResponse( $builder->only(['qrCode']) );

       } catch(ValidationException $exception) {

            throw $exception;
       }
       
       catch (\Throwable $th) {

            throw $th;
       }
    }
}