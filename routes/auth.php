<?php

use App\Modules\CBT\Models\AssessmentModel;
use App\Modules\UserManager\Constants\UserManagerConstants;
use App\Modules\UserManager\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('adminer/login', fn() => Inertia::render(UserManagerConstants::LOGIN_VIEW));

Route::get('teacher/login', fn() => Inertia::render(UserManagerConstants::LOGIN_VIEW));

Route::get('two-factor', fn() =>  Inertia::render(UserManagerConstants::TWO_FACTOR_VIEW) )->middleware(['auth', 'auth.token']);

Route::post('adminer/login', [AuthController::class, 'login']);

Route::get('/cbt/{assessment:uuid}', fn(AssessmentModel $assessment) => Inertia::render('CBT/Student/Login', [ 'assessmentId' => $assessment->uuid ]) )->middleware('cbt') ;
Route::post('/cbt/{assessment:uuid}', [ AuthController::class, 'CBTLogin'])->middleware('cbt');

Route::post('/cbt/{assessment:uuid}/logout', [ AuthController::class, 'CBTLogout'])->middleware(['auth:student']);