<?php

use App\Modules\UserManager\Constants\UserManagerConstants;
use App\Modules\UserManager\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('login', fn() => Inertia::render(UserManagerConstants::LOGIN_VIEW));
Route::get('two-factor', fn() =>  Inertia::render(UserManagerConstants::TWO_FACTOR_VIEW) )->middleware(['auth', 'auth.token']);

Route::post('login', [AuthController::class, 'login']);