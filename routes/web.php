<?php

use App\Models\User;
use App\Modules\CBT\Models\AssessmentModel;
use App\Modules\UserManager\Constants\UserManagerConstants;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Sanctum\PersonalAccessToken;
use PragmaRX\Google2FAQRCode\Google2FA;
use PragmaRX\Google2FAQRCode\QRCode\Bacon;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

require __DIR__ . '/auth.php';

Route::get('/dashboard', fn() => Inertia::render('Dashboard/Index') );

Route::get('/assessments', fn() => Inertia::render('CBT/Assessment/Index') );
Route::get('/assessments/termly', fn() => Inertia::render('CBT/Assessment/TermlyAssessment') );
Route::get('/assessments/standalone', fn() => Inertia::render('CBT/Assessment/StandaloneAssessment') );

Route::get('/assessments/termly/classes/{assessment:uuid}', fn(AssessmentModel $assessment) => Inertia::render('CBT/Assessment/TermlyAssessmentClasses', ['assessmentId' => $assessment->uuid, 'title' => $assessment->title ]) );
Route::get('/assessments/termly/schedule/{assessment:uuid}', fn(AssessmentModel $assessment) => Inertia::render('CBT/Assessment/TermlyAssessmentSchedule', ['assessmentId' => $assessment->uuid, 'title' => $assessment->title ]) );

Route::get('/questions/create/{assessment:uuid}', fn(AssessmentModel $assessment) => Inertia::render('CBT/Questions/Create', ['assessmentId' => $assessment->uuid, 'title' => $assessment->title ] ) );

Route::get('/assessments/classes/{assessment:uuid}', fn(AssessmentModel $assessment) => Inertia::render('CBT/Assessment/AssessmentClassesView', ['assessmentId' => $assessment->uuid, 'title' => $assessment->title ] )  );
Route::get('/assessments/schedule/{assessment:uuid}', fn(AssessmentModel $assessment) => Inertia::render('CBT/Assessment/AssessmentClassesView', ['assessmentId' => $assessment->uuid, 'title' => $assessment->title ] )  );


Route::get('/assessment-types', fn() => Inertia::render('CBT/Assessment/AssessmentTypesView') );

Route::get('/classes', fn() => Inertia::render('SchoolManager/Classes/Index') );
Route::get('/subjects', fn() => Inertia::render('SchoolManager/Subjects/Index') );
Route::get('/students', fn() => Inertia::render('SchoolManager/Students/Index') );
Route::get('/academic-sessions', fn() => Inertia::render('SchoolManager/Sessions/Index') );
Route::get('/terms', fn() => Inertia::render('SchoolManager/Terms/Index') );


Route::get('/cbt', fn() => Inertia::render('CBT/Student/Login')) ;
Route::get('/cbt/i', fn() => Inertia::render('CBT/Student/ExamIntro')) ;
Route::get('/cbt/i/exam', fn() => Inertia::render('CBT/Student/Exam')) ;









