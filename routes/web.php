<?php

use App\Models\User;
use App\Modules\CBT\Controllers\ExamController;
use App\Modules\CBT\Models\AssessmentModel;
use App\Modules\SchoolManager\Models\ClassModel;
use App\Modules\SchoolManager\Models\StudentProfileModel;
use App\Modules\SchoolManager\Models\SubjectModel;
use App\Modules\UserManager\Constants\UserManagerConstants;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
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


Route::get('setup', function(){

    SubjectModel::create(['subject_name' => 'APPLIED ANATOMY AND PHYSIOLOGY', 'subject_code' => 'BMP 210']);
    SubjectModel::create(['subject_name' => 'FUNDAMENTALS OF MIDWIFERY PRACTICE', 'subject_code' => 'BMP 211']);
    SubjectModel::create(['subject_name' => 'NORMAL MIDWIFERY', 'subject_code' => 'BMP 212']);
    SubjectModel::create(['subject_name' => 'PHARMACOLOGY II', 'subject_code' => 'BMP 213']);
    SubjectModel::create(['subject_name' => 'FAMILY PLANNING I', 'subject_code' => 'BMP 214']);
    SubjectModel::create(['subject_name' => 'MEDICAL SURGICAL NURSING II', 'subject_code' => 'BMP 215']);
    SubjectModel::create(['subject_name' => 'COMMUNITY MIDWIFERY', 'subject_code' => 'BMP 216']);
    SubjectModel::create(['subject_name' => 'SEMINAR IN MIDWIFERY PRACTICE II', 'subject_code' => 'BMP 217']);
    SubjectModel::create(['subject_name' => 'HOSPITAL BASED MIDWIFERY PRACTICE II', 'subject_code' => 'BMP 218']);
    SubjectModel::create(['subject_name' => 'INFANT I', 'subject_code' => 'BMP 219']);

    $subjects = SubjectModel::get()->pluck('id');



    StudentProfileModel::where('class_id', 2)->get()->each(fn($student) => $student->subjects()->sync($subjects));
});

Route::get('/dashboard', fn() => Inertia::render('Dashboard/Index') );

//Assessments
Route::get('/assessments', fn() => Inertia::render('CBT/Assessment/Index') );

Route::get('/assessments/termly', fn() => Inertia::render('CBT/Assessment/termly/TermlyAssessment') );
Route::get('/assessments/standalone', fn() => Inertia::render('CBT/Assessment/standalone/StandaloneAssessment') );

Route::get('/assessments/termly/classes/{assessment:uuid}', fn(AssessmentModel $assessment) => Inertia::render('CBT/Assessment/termly/TermlyAssessmentClasses', ['assessmentId' => $assessment->uuid, 'title' => $assessment->title ]) );
Route::get('/assessments/termly/schedule/{assessment:uuid}', fn(AssessmentModel $assessment) => Inertia::render('CBT/Assessment/termly/TermlyAssessmentSchedule', ['assessmentId' => $assessment->uuid, 'title' => $assessment->title ]) );
Route::get('/assessments/termly/view/{assessment:uuid}', fn(AssessmentModel $assessment) => Inertia::render('CBT/Assessment/termly/View', ['assessmentId' => $assessment->uuid, 'title' => $assessment->title ]) );



//Assessment Types
Route::get('/assessment-types', fn() => Inertia::render('CBT/Assessment/assessment_types/AssessmentTypesView') );

//Questions
Route::get('/questions/create/s/{assessment:uuid}', function(AssessmentModel $assessment){
    if( ! $assessment->is_standalone ) abort(404);
    return Inertia::render('CBT/Questions/Create', ['assessmentId' => $assessment->uuid, 'title' => $assessment->title ] );
} );

Route::get('/questions/create/t/{assessment:uuid}/{subject}/{class}', function(AssessmentModel $assessment, SubjectModel $subject, $class){
    if( $assessment->is_standalone ) abort(404);
    return Inertia::render('CBT/Questions/Create', ['assessmentId' => $assessment->uuid, 'title' => $assessment->title, 'subjectId' => $subject->id, 'classId' => $class ] );
} );

//Classes
Route::get('/classes', fn() => Inertia::render('SchoolManager/Classes/Index') );

//Subjects
Route::get('/subjects', fn() => Inertia::render('SchoolManager/Subjects/Index') );

//Students
Route::get('/students', fn() => Inertia::render('SchoolManager/Students/Index') );

Route::get('/students/create', fn() => Inertia::render('SchoolManager/Students/Create') );

//Teachers
Route::get('/teachers', fn() => Inertia::render('SchoolManager/Teachers/Index') );

//Academic Sessions
Route::get('/academic-sessions', fn() => Inertia::render('SchoolManager/Sessions/Index') );

//Terms
Route::get('/terms', fn() => Inertia::render('SchoolManager/Terms/Index') );



Route::middleware(['auth'])->group(function(){
    Route::get('/teacher/dashboard', fn() => Inertia::render('CBT/Teacher/Dashboard') );
    Route::get('/teacher/class-subjects/{class:class_code}', fn(ClassModel $class) => Inertia::render('CBT/Teacher/Subjects', ['classCode' => $class->class_code]) );
    Route::get('/teacher/create-questions/{class:class_code}/{subject}', fn(ClassModel $class, SubjectModel $subject) => Inertia::render('CBT/Teacher/QuestionsIndex', [ 'classCode' => $class->class_code, 'subjectId' => $subject->id ]) );
    Route::get('/teacher/questions/{class:class_code}/{subject}/{assessment}', fn(ClassModel $class, SubjectModel $subject, $assessment) => Inertia::render('CBT/Teacher/CreateQuestions', [ 'classCode' => $class->class_code, 'subjectId' => $subject->id, 'assessmentId' => $assessment ]) );
});



//CBT
Route::middleware(['auth:student', 'cbt', 'cbt.session'])->group(function() {

    Route::get('/cbt/{assessment:uuid}/s', fn(AssessmentModel $assessment) => Inertia::render('CBT/Exams/Standalone', [ 'assessmentId' => $assessment->uuid ]) ) ;
    Route::get('/cbt/save-session/student/{assessment:uuid}', [ ExamController::class, 'examSessionTimer' ]);
    
    Route::get('/cbt/{assessment:uuid}/t', fn(AssessmentModel $assessment) => Inertia::render('CBT/Exams/Termly/Index', [ 'assessmentId' => $assessment->uuid ]) ) ;

    Route::get('/cbt/{assessment:uuid}/t/i', fn(AssessmentModel $assessment) => Inertia::render('CBT/Exams/Termly/Exam', [ 'assessmentId' => $assessment->uuid ]) ) ;  
});









