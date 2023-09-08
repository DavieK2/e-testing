<?php

use App\Models\User;
use App\Modules\CBT\Controllers\ExamController;
use App\Modules\CBT\Models\AssessmentModel;
use App\Modules\SchoolManager\Models\ClassModel;
use App\Modules\SchoolManager\Models\SubjectModel;
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

Route::get('/', fn() => Inertia::render('Dashboard/Index') );
Route::get('/dashboard', fn() => Inertia::render('Dashboard/Index') );



//Assessments
Route::get('/assessments', fn() => Inertia::render('CBT/Assessment/Index') );
Route::get('/assessments/termly', fn() => Inertia::render('CBT/Assessment/TermlyAssessment') );
Route::get('/assessments/standalone', fn() => Inertia::render('CBT/Assessment/StandaloneAssessment') );
Route::get('/assessments/termly/classes/{assessment:uuid}', fn(AssessmentModel $assessment) => Inertia::render('CBT/Assessment/TermlyAssessmentClasses', ['assessmentId' => $assessment->uuid, 'title' => $assessment->title ]) );
Route::get('/assessments/termly/schedule/{assessment:uuid}', fn(AssessmentModel $assessment) => Inertia::render('CBT/Assessment/TermlyAssessmentSchedule', ['assessmentId' => $assessment->uuid, 'title' => $assessment->title ]) );
Route::get('/assessments/classes/{assessment:uuid}', fn(AssessmentModel $assessment) => Inertia::render('CBT/Assessment/AssessmentClassesView', ['assessmentId' => $assessment->uuid, 'title' => $assessment->title ] )  );
Route::get('/assessments/schedule/{assessment:uuid}', fn(AssessmentModel $assessment) => Inertia::render('CBT/Assessment/AssessmentClassesView', ['assessmentId' => $assessment->uuid, 'title' => $assessment->title ] )  );

//Assessment Types
Route::get('/assessment-types', fn() => Inertia::render('CBT/Assessment/AssessmentTypesView') );

//Questions
Route::get('/questions/create/{assessment:uuid}', fn(AssessmentModel $assessment) => Inertia::render('CBT/Questions/Create', ['assessmentId' => $assessment->uuid, 'title' => $assessment->title ] ) );

//Classes
Route::get('/classes', fn() => Inertia::render('SchoolManager/Classes/Index') );

//Subjects
Route::get('/subjects', fn() => Inertia::render('SchoolManager/Subjects/Index') );

//Students
Route::get('/students', fn() => Inertia::render('SchoolManager/Students/Index') );

//Teachers
Route::get('/teachers', fn() => Inertia::render('SchoolManager/Teachers/Index') );

//Academic Sessions
Route::get('/academic-sessions', fn() => Inertia::render('SchoolManager/Sessions/Index') );

//Terms
Route::get('/terms', fn() => Inertia::render('SchoolManager/Terms/Index') );


Route::get('/cbt/{assessment:uuid}', fn(AssessmentModel $assessment) => Inertia::render('CBT/Student/Login', [ 'assessmentId' => $assessment->uuid ]) ) ;
Route::get('/cbt/{assessment:uuid}/s', fn(AssessmentModel $assessment) => Inertia::render('CBT/Exams/Standalone', [ 'assessmentId' => $assessment->uuid ]) ) ;
Route::get('/cbt/i/exam', fn() => Inertia::render('CBT/Student/Exam')) ;





Route::get('/teacher/dashboard', fn() => Inertia::render('CBT/Teacher/Dashboard') );
Route::get('/teacher/class-subjects/{class:class_code}', fn(ClassModel $class) => Inertia::render('CBT/Teacher/Subjects', ['classCode' => $class->class_code]) );
Route::get('/teacher/create-questions/{class:class_code}/{subject}', fn(ClassModel $class, SubjectModel $subject) => Inertia::render('CBT/Teacher/QuestionsIndex', [ 'classCode' => $class->class_code, 'subjectId' => $subject->id ]) );
Route::get('/teacher/questions/{class:class_code}/{subject}/{assessment}', fn(ClassModel $class, SubjectModel $subject, $assessment) => Inertia::render('CBT/Teacher/CreateQuestions', [ 'classCode' => $class->class_code, 'subjectId' => $subject->id, 'assessmentId' => $assessment ]) );


Route::get('/cbt/save-session/student/{assessment:uuid}', [ ExamController::class, 'getStudentStandaloneExamSessionTime' ]);







