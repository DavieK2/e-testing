<?php

namespace App\Modules\UserManager\Facades;


use App\Modules\UserManager\Tasks\TwoFactorAuthenticationTasks as TasksTwoFactorAuthenticationTasks;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void checkIfUserHas2FA()
 * @method static void checkIfUser2FAHasExpired()
 * @method static void verifyOTP()
 * @method static \App\Modules\UserManager\Tasks\TwoFactorAuthenticationTasks withParameters(array $params)
 * @method static \App\Modules\UserManager\Tasks\TwoFactorAuthenticationTasks except(array $keys, bool $recursive = false)
 * @method static \App\Modules\UserManager\Tasks\TwoFactorAuthenticationTasks only(array $keys)
 * @method static \App\Modules\UserManager\Tasks\TwoFactorAuthenticationTasks empty()
 * @method static \App\Modules\UserManager\Tasks\TwoFactorAuthenticationTasks perPage()
 * @method static \App\Modules\UserManager\Tasks\TwoFactorAuthenticationTasks all()
 * @method static \App\Modules\UserManager\Tasks\TwoFactorAuthenticationTasks asArray()
 * @method static void getItems()
 * @method static void setItem(void $value)
 * @method static \App\Modules\UserManager\Tasks\TwoFactorAuthenticationTasks search()
 * @method static \App\Modules\UserManager\Tasks\TwoFactorAuthenticationTasks filter()
 * @method static \App\Modules\UserManager\Tasks\TwoFactorAuthenticationTasks sort()
 * @method static void formatResponse(\App\Contracts\ResponseType $responseType = unknown, array $options = [], string $formatter = '')
 *
 * @see \App\Modules\UserManager\Tasks\TwoFactorAuthenticationTasks
 */

class TwoFactorAuthenticationTasks extends Facade{

    protected static function getFacadeAccessor()
    {
        return TasksTwoFactorAuthenticationTasks::class;
    }
}