<?php

use App\Modules\CBT\Models\AssessmentModel;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Inertia\Inertia;


Route::get('/assessments', fn() => Inertia::render('CBT/AssessmentManager/Dashboard/Index') );

Route::get('/assessments/quiz', fn() => Inertia::render('CBT/AssessmentManager/Quiz/Create_Quiz/page/Index') );
Route::get('/assessments/quiz/edit/{assessment}', fn(AssessmentModel $assessment) => Inertia::render('CBT/AssessmentManager/Quiz/Create_Quiz/page/Index', ['assessmentId' => $assessment->uuid] ));

Route::get('/assessments/quiz/question-manager/{assessment:uuid}', fn(AssessmentModel $assessment) => Inertia::render('CBT/QuestionsManager/Quiz/page/Index', ['assessmentId' => $assessment->uuid, 'assessmentTitle' => Str::headline($assessment->title) ]) );
Route::get('/assessments/quiz/question-manager/create/{assessment:uuid}', fn(AssessmentModel $assessment) => Inertia::render('CBT/Assessment/standalone/question_bank/Create', ['assessmentId' => $assessment->uuid, 'assessmentTitle' => Str::headline($assessment->title) ]) );


//Termly Assessments
Route::get('/assessments/termly', fn() => Inertia::render('CBT/Assessment/Termly/Create_Assessment/page/TermlyAssessment') );
Route::get('/assessments/termly/classes/{assessment:uuid}', fn(AssessmentModel $assessment) => Inertia::render('CBT/Assessment/Termly/Create_Assessment/page/TermlyAssessmentClasses', ['assessmentId' => $assessment->uuid, 'title' => Str::headline($assessment->title) ]) );
Route::get('/assessments/termly/schedule/{assessment:uuid}', fn(AssessmentModel $assessment) => Inertia::render('CBT/Assessment/Termly/Create_Assessment/page/TermlyAssessmentSchedule', ['assessmentId' => $assessment->uuid, 'title' => Str::headline($assessment->title) ]) );
Route::get('/assessments/termly/manage/{assessment:uuid}', fn(AssessmentModel $assessment) => Inertia::render('CBT/Assessment/Termly/Manage_Assessment/page/Manage', ['assessmentId' => $assessment->uuid, 'assessmentTitle' => Str::headline($assessment->title) ]) );
