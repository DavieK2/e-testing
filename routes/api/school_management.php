<?php

use App\Modules\SchoolManager\Controllers\AcademicSessionController;
use App\Modules\SchoolManager\Controllers\ClassController;
use App\Modules\SchoolManager\Controllers\StudentController;
use App\Modules\SchoolManager\Controllers\SubjectController;
use App\Modules\SchoolManager\Controllers\TeacherController;
use App\Modules\SchoolManager\Controllers\TermController;
use Illuminate\Support\Facades\Route;



// Route::middleware(['auth:sanctum'])->group(function(){

    // .............................. Teacher Management ....................................................................

    Route::get('/teachers', [ TeacherController::class, 'teachers']);
    Route::post('/teacher/create', [ TeacherController::class, 'createTeacher']);
    Route::post('/teacher/update/{teacher}', [ TeacherController::class, 'updateTeacher']);
    Route::post('/teacher/assign-subjects/{teacher}', [ TeacherController::class, 'assignTeacherToSubject']);
    Route::post('/teacher/assign-classes/{teacher}', [ TeacherController::class, 'assignTeacherToClass']);
    Route::post('/teacher/assign-class-subjects/{teacher}', [ TeacherController::class, 'assignTeacherToClassSubjects']);

    Route::get('/teacher/assigned-subjects/{teacher}', [ TeacherController::class, 'getTeacherAssignedSubjects']);
    Route::get('/teacher/assigned-classes/{teacher}', [ TeacherController::class, 'getTeacherAssignedClasses']);
    Route::get('/teacher/assigned-class-subjects/{teacher}', [ TeacherController::class, 'getTeacherAssignedClassSubjects']);

    //...........................................................................................................




    // .............................. Class Management ....................................................................

    Route::get('/classes', [ ClassController::class, 'index']);
    Route::post('/class/create', [ ClassController::class, 'create' ]);
    Route::post('/class/update/{class}', [ ClassController::class, 'update' ]);
    Route::get('/class/subjects/{class}', [ ClassController::class, 'subjects']);
    Route::post('/class/assign-subjects/{class}', [ ClassController::class, 'assignSubjects']);

    //...........................................................................................................




    // ............................. Subject Management ....................................................................
 
    Route::get('/subjects', [ SubjectController::class, 'index']);
    Route::post('/subject/create', [ SubjectController::class, 'create']);
    Route::post('/subject/class/{subject}', [ SubjectController::class, 'classes']);
    Route::post('/subject/update/{subject}', [ SubjectController::class, 'update']);

    //...........................................................................................................



    // ............................... Student Management ....................................................................

    Route::get('/students', [ StudentController::class, 'index']);
    Route::post('/student/create', [ StudentController::class, 'create']);
    Route::post('/student/update/{student}', [ StudentController::class, 'update']);
    Route::post('/student/upload', [ StudentController::class, 'upload']);
    Route::post('/student/import', [ StudentController::class, 'import']);
    Route::post('/students/download', [ StudentController::class, 'downloadStudentData']);

    Route::post('/student-profile/create', [ StudentController::class, 'createStudentProfile']);

    Route::post('/student/assign-subjects/{student}', [ StudentController::class, 'assignStudentToSubject']);
    Route::get('/student/assigned-subjects/{student}', [ StudentController::class, 'getStudentAssignedSubjects']);
    Route::post('/students/mass-assign-subjects', [ StudentController::class, 'massAssignSubjectsToStudents']);

    //...........................................................................................................


    // ............................... Term Management ....................................................................

    Route::get('/terms', [ TermController::class, 'index']);
    Route::post('/term/create', [ TermController::class, 'create']);
    Route::post('/term/update/{term}', [ TermController::class, 'update']);

    //...........................................................................................................


    // ............................... Academic Session Management ....................................................................


    Route::get('/sessions', [ AcademicSessionController::class, 'index']);
    Route::post('/session/create', [ AcademicSessionController::class, 'create']);
    Route::post('/session/update/{academic_session}', [ AcademicSessionController::class, 'update']);

    //...........................................................................................................


// });