<?php

use App\Modules\CBT\Controllers\AssessmentController;
use App\Modules\CBT\Controllers\AssessmentTypeController;
use Illuminate\Support\Facades\Route;



Route::get('/assessments', [ AssessmentController::class, 'index' ]);


Route::get('/assessment-types', [ AssessmentTypeController::class, 'index' ]);
Route::post('/assessment-type/create', [ AssessmentTypeController::class, 'create' ]);
Route::post('/assessment-type/update/{assessment_type}', [ AssessmentTypeController::class, 'update' ]);



// Route::get('/assessments', [ AssessmentController::class, 'index' ]);
Route::get('/published-assessments', [ AssessmentController::class, 'getPublishedAssessments' ]);
Route::get('/assessment/{assessment:uuid}', [ AssessmentController::class, 'show' ]);

Route::post('/assessment/quiz/create', [ AssessmentController::class, 'createQuiz' ]);
Route::get('/assessment/quiz/edit/{assessment}', [ AssessmentController::class, 'editQuiz' ]);
Route::post('/assessment/quiz/update/{assessment}', [ AssessmentController::class, 'updateQuiz' ]);


Route::post('/assessment/create', [ AssessmentController::class, 'create' ]);
Route::post('/assessment/update', [ AssessmentController::class, 'update' ]);
Route::post('/assessment/publish', [ AssessmentController::class, 'publish' ]);

Route::post('/assessment/publish/termly', [ AssessmentController::class, 'publishTermly' ]);

Route::post('/assessment/assign-classes', [ AssessmentController::class, 'addClassesToAssessment' ]);
Route::post('/assessment/termly/complete', [ AssessmentController::class, 'complete' ]);