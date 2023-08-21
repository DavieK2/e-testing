<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class AuthTokenGuard
{
    
    public function handle(Request $request, Closure $next)
    {
        $user = PersonalAccessToken::findToken( request()->cookie('token') )?->tokenable;

        if( ( is_null($user) ) || ( ! $user->is(auth()->user()) ) ) abort(401);

        return $next($request);
    }
}
