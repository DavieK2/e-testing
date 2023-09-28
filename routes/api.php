<?php

use App\Modules\CBT\Controllers\AssessmentController;
use App\Modules\CBT\Controllers\AssessmentResultController;
use App\Modules\CBT\Controllers\AssessmentTypeController;
use App\Modules\CBT\Controllers\ExamController;
use App\Modules\CBT\Controllers\QuestionController;
use App\Modules\CBT\Controllers\TeacherController;
use App\Modules\SchoolManager\Controllers\AcademicSessionController;
use App\Modules\SchoolManager\Controllers\ClassController;
use App\Modules\SchoolManager\Controllers\StudentController;
use App\Modules\SchoolManager\Controllers\SubjectController;
use App\Modules\SchoolManager\Controllers\TermController;
use App\Modules\SchoolManager\Controllers\UserController;
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
Route::get('/published-assessments', [ AssessmentController::class, 'getPublishedAssessments' ]);
Route::get('/assessment/{assessment:uuid}', [ AssessmentController::class, 'show' ]);

Route::get('/assessment-classes/{assessment:uuid}', [ AssessmentController::class, 'getAssessmentClasses' ]);
Route::get('/assessment-subjects/{assessment:uuid}', [ AssessmentController::class, 'getAssessmentSubjects' ]);

Route::post('/assessment/create', [ AssessmentController::class, 'create' ]);
Route::post('/assessment/update', [ AssessmentController::class, 'update' ]);
Route::post('/assessment/publish', [ AssessmentController::class, 'publish' ]);

Route::post('/assessment/publish/termly', [ AssessmentController::class, 'publishTermly' ]);

Route::post('/assessment/assign-classes', [ AssessmentController::class, 'addClassesToAssessment' ]);
Route::post('/assessment/termly/complete', [ AssessmentController::class, 'complete' ]);


Route::get('/questions/{assessment:uuid}', [ QuestionController::class, 'getQuestions']);
Route::get('/question-bank', [ QuestionController::class, 'getQuestionBank']);
Route::post('/question/create/{assessment:uuid}', [ QuestionController::class, 'create']);
Route::post('/question/update/{assessment:uuid}', [ QuestionController::class, 'update']);
Route::post('/question/assign/{assessment:uuid}', [ QuestionController::class, 'assignQuestionToAssessment']);
Route::post('/question/unassign/{assessment:uuid}', [ QuestionController::class, 'unAssignQuestionFromAssessment']);
Route::post('/question/import', [ QuestionController::class, 'import']);


Route::get('/classes', [ ClassController::class, 'index']);
Route::post('/class/create', [ ClassController::class, 'create' ]);
Route::post('/class/update', [ ClassController::class, 'update' ]);
Route::get('/class/subject/{class}', [ ClassController::class, 'subjects']);
Route::post('/class/assign-subjects', [ ClassController::class, 'assignSubjects']);

Route::get('/subjects', [ SubjectController::class, 'index']);
Route::post('/subject/create', [ SubjectController::class, 'create']);
Route::post('/subject/update', [ SubjectController::class, 'update']);

Route::get('/students', [ StudentController::class, 'index']);
Route::post('/student/create', [ StudentController::class, 'create']);

Route::post('/student-profile/create', [ StudentController::class, 'createStudentProfile']);

Route::post('/student/assign-subjects', [ StudentController::class, 'assignStudentToSubject']);
Route::get('/student/assigned-subjects/{student}', [ StudentController::class, 'getStudentAssignedSubjects']);

Route::get('/teachers', [ UserController::class, 'teachers']);
Route::post('/teacher/create', [ UserController::class, 'createTeacher']);
Route::post('/teacher/update/{teacher}', [ UserController::class, 'updateTeacher']);
Route::post('/teacher/assign-subjects', [ UserController::class, 'assignTeacherToSubject']);
Route::post('/teacher/assign-classes', [ UserController::class, 'assignTeacherToClass']);
Route::get('/teacher/assigned-subjects/{teacher}', [ UserController::class, 'getTeacherAssignedSubjects']);
Route::get('/teacher/assigned-classes/{teacher}', [ UserController::class, 'getTeacherAssignedClasses']);

Route::get('/terms', [ TermController::class, 'index']);
Route::post('/term/create', [ TermController::class, 'create']);
Route::post('/term/update', [ TermController::class, 'update']);

Route::get('/sessions', [ AcademicSessionController::class, 'index']);
Route::post('/session/create', [ AcademicSessionController::class, 'create']);
Route::post('/session/update', [ AcademicSessionController::class, 'update']);


Route::get('/results/assessment-subjects/{assessment:uuid}', [ AssessmentResultController::class, 'subjects']);
Route::post('/assessment/t/results', [ AssessmentResultController::class, 'getTermlyAssessmentResults']);

Route::post('/assessment/student/results', [ AssessmentResultController::class, 'getStudentResults']);


Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('/get-classes', [ TeacherController::class, 'getClasses' ]);
    Route::get('/get-subjects/{class:class_code}', [ TeacherController::class, 'getSubjects' ]);
    Route::get('/get-questions', [ TeacherController::class, 'getAssessmentQuestions' ]);
});


Route::post('/student/check-in/get', [ ExamController::class, 'checkInStudentData'] );
Route::post('/student/check-in/{assessment:uuid}', [ ExamController::class, 'checkInStudent'] );

//Student CBT

Route::middleware(['auth:sanctum', 'cbt', 'cbt.session'])->group(function(){
    //Standalone
    Route::get('/cbt/session/questions/{assessment:uuid}', [ ExamController::class, 'getAssessmentQuestions' ]);
    Route::get('/cbt/session/student/{assessment:uuid}', [ ExamController::class, 'getStudentStandaloneExamSession' ]);
    Route::post('/cbt/start-session/student/{assessment:uuid}', [ ExamController::class, 'startStudentStandaloneExamSession' ]);
    
    Route::post('/cbt/save-answer/student/{assessment:uuid}', [ ExamController::class, 'saveStudentExamSessionAnswer' ]);
    Route::get('/cbt/get-responses/student/{assessment:uuid}', [ ExamController::class, 'getStudentExamSessionResponses' ]);
    Route::post('/cbt/complete/student/{assessment:uuid}', [ ExamController::class, 'submitExam' ]);

    //Termly
    Route::get('/cbt/t/session/student/{assessment:uuid}', [ ExamController::class, 'getStudentTermlyExamAssessments' ]);
    Route::get('/cbt/t/session/student/{assessment:uuid}/{subject:subject_code}', [ ExamController::class, 'getStudentTermlyExamAssessmentSession' ]);
    Route::post('/cbt/t/start-session/student/{assessment:uuid}/{subject:subject_code}', [ ExamController::class, 'startStudentTermlyExamSession' ]);



});
