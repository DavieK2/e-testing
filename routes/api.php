<?php

use App\Modules\CBT\Controllers\AssessmentController;
use App\Modules\CBT\Controllers\AssessmentTypeController;
use App\Modules\CBT\Controllers\QuestionController;
use App\Modules\SchoolManager\Controllers\AcademicSessionController;
use App\Modules\SchoolManager\Controllers\ClassController;
use App\Modules\SchoolManager\Controllers\SubjectController;
use App\Modules\SchoolManager\Controllers\TermController;
use App\Modules\UserManager\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/2faa', [ AuthController::class, 'get2FA' ]);
Route::middleware('auth:sanctum')->post('/two_factor_verify', [ AuthController::class, 'verify2FA' ]);

Route::get('/assessment-types', [ AssessmentTypeController::class, 'index' ]);
Route::post('/assessment-type/create', [ AssessmentTypeController::class, 'create' ]);
Route::post('/assessment-type/update', [ AssessmentTypeController::class, 'update' ]);

//Ass
Route::get('/assessments', [ AssessmentController::class, 'index' ]);
Route::get('/assessment/{assessment:uuid}', [ AssessmentController::class, 'show' ]);

Route::get('/assessment-classes/{assessment:uuid}', [ AssessmentController::class, 'getAssessmentClasses' ]);
Route::get('/assessment-subjects/{assessment:uuid}', [ AssessmentController::class, 'getAssessmentSubjects' ]);

Route::post('/assessment/create', [ AssessmentController::class, 'create' ]);
Route::post('/assessment/update', [ AssessmentController::class, 'update' ]);
Route::post('/assessment/publish', [ AssessmentController::class, 'publish' ]);

Route::post('/assessment/assign-classes', [ AssessmentController::class, 'addClassesToAssessment' ]);
Route::post('/assessment/termly/complete', [ AssessmentController::class, 'complete' ]);


Route::get('/questions/{assessment:uuid}', [ QuestionController::class, 'getQuestions']);
Route::get('/question-bank', [ QuestionController::class, 'getQuestionBank']);
Route::post('/question/create/{assessment:uuid}', [ QuestionController::class, 'create']);
Route::post('/question/update/{assessment:uuid}', [ QuestionController::class, 'update']);
Route::post('/question/assign/{assessment:uuid}', [ QuestionController::class, 'assignQuestionToAssessment']);
Route::post('/question/unassign/{assessment:uuid}', [ QuestionController::class, 'unAssignQuestionFromAssessment']);


Route::get('/classes', [ ClassController::class, 'index']);
Route::post('/class/create', [ ClassController::class, 'create' ]);
Route::post('/class/update', [ ClassController::class, 'update' ]);
Route::get('/class/subject/{class}', [ ClassController::class, 'subjects']);
Route::post('/class/assign-subjects', [ ClassController::class, 'assignSubjects']);

Route::get('/subjects', [ SubjectController::class, 'index']);
Route::post('/subject/create', [ SubjectController::class, 'create']);
Route::post('/subject/update', [ SubjectController::class, 'update']);

Route::get('/terms', [ TermController::class, 'index']);
Route::post('/term/create', [ TermController::class, 'create']);
Route::post('/term/update', [ TermController::class, 'update']);

Route::get('/sessions', [ AcademicSessionController::class, 'index']);
Route::post('/session/create', [ AcademicSessionController::class, 'create']);
Route::post('/session/update', [ AcademicSessionController::class, 'update']);






//Student CBT
Route::get('/cbt/session/{assessment:uuid}', [ AssessmentController::class, 'getAssessmentQuestions' ]);