<?php


use App\Modules\CBT\Controllers\ExamController;
use App\Modules\CBT\Enums\QuizContributorsEnum;
use App\Modules\CBT\Facades\AssessmentListTasks;
use App\Modules\CBT\Facades\AssessmentTypeListTasks;
use App\Modules\CBT\Facades\CreateAssessmentTasks;
use App\Modules\CBT\Models\AssessmentModel;
use App\Modules\CBT\Models\QuestionBankModel;
use App\Modules\CBT\Models\QuestionModel;
use App\Modules\CBT\Resources\GetAssessmentQuestionsFormatter;
use App\Modules\CBT\Resources\QuestionListResource;
use App\Modules\Excel\Export;
use App\Modules\SchoolManager\Models\AcademicSessionModel;
use App\Modules\SchoolManager\Models\ClassModel;
use App\Modules\SchoolManager\Models\StudentProfileModel;
use App\Modules\SchoolManager\Models\SubjectModel;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

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
require __DIR__ . '/cbt_management.php';


Route::get('/add-more-time', function(){

    $time = request('time');
    $student = request('studentId');

    if( is_null( $time ) ) return 'Please specify time to add';

    if( $time && is_null( $student ) ){

        $addn_time = (intval($time) * 60);

        Redis::publish('add-time', $addn_time); 

        return "An additional time of {$time} minutes has been added to all students";
    }

    if( $time && $student){

        $student = StudentProfileModel::firstWhere('student_code', $student)?->uuid;

        if( $student ){

            $addn_time = (intval($time) * 60);

            Redis::publish("add-time-{$student}", $addn_time); 

            return "An additional time of {$time} minutes has been added to the students exam";
        }
    }
   
    
})->middleware('auth');


Route::get('/pdf', function(){


    $assessment_subject = AssessmentModel::first()->subjects->map( fn($subject) => ['subject_name' => $subject->subject_name, 'subject_id' => $subject->uuid ]);

    $assessment_subjects = $assessment_subject->pluck('subject_id')->toArray();

    $assessment_subject_name = $assessment_subject->pluck('subject_name')->toArray();

    $count = 1;

    $results = DB::table('assessment_results')->get()->groupBy('student_profile_id')->map( function($student, $studentId) use($assessment_subjects){


        $stu = StudentProfileModel::find( $studentId );

        $data = [];

        foreach ( $assessment_subjects as $key => $sub ) {
            
            $sub_result = $student->filter( fn($res) => $res->subject_id === $sub )->first();

            if( ! empty($sub_result) ){

                $data[$sub] = $sub_result->grade;

            }else{

                $data[$sub] = '-';
            }
        }  
        
        return ['student_name' => "$stu->first_name $stu->surname", 'form_number' => $stu->student_code, 'program_of_study' => $stu->program_of_study, ...$data, 'total_score' =>  $student->sum('points') ];

    })->values()
    ->sortBy('total_score', descending: true)
    ->map( function($result) use(&$count) {

        return ['s/n' => $count ++ ] + $result; 

    } );


   

    $headings = ['S/N', 'STUDENT NAME', 'FORM NUMBER', 'PROGRAM OF STUDY', ...$assessment_subject_name, 'TOTAL SCORE' ];

    return Excel::download( new Export($results, $headings), 'predegree_results.xlsx');

});


Route::get('/pdf-result', function(){

    $assessment_subjects = AssessmentModel::first()->subjects->map( fn($subject) => ['subject_name' => $subject->subject_name, 'subject_id' => $subject->uuid ]);

    return view('result_pdf', ['assessment_subjects' => $assessment_subjects ]);

} );

Route::get('/', function () {
    return inertia('Index');
});


Route::get('/test', function(){


    // $path = base_path('app/Modules/CBT/Requests/CreateAssessmentQuestionSectionRequest.php');

    // Artisan::call("autodoc:facades", ['paths' => ['app/Modules/UserManager/Facades']]);
    // dd( AssessmentListTasks::getAssignedAssesments() );

    // $modules = scandir( base_path('app/Modules') );

    // unset($modules[0]);
    // unset($modules[1]);

    // $files = [];
    
    // foreach ($modules as $module) {
       
        $path = base_path("app/Modules/CBT/Tasks");
                
    //     if( ! file_exists( $path ) ) continue;
        

        $files = scandir( $path );

        unset($files[0]);
        unset($files[1]);




        foreach( $files as $file ){
    
            // $file_path = "$path/$file";  

            $class = explode('.', $file);
            $class = $class[0];

            // $class = str_replace('Feature', 'Tasks', $class);

            // dd( $class );

            Artisan::call("module:facade $class --module=CBT");

            // $contents = file_get_contents( $file_path );

            // $new_content = str_replace('use Illuminate\Foundation\Http\FormRequest;', 'use App\Http\Requests\BaseRequest;', $contents);
            // $new_content = str_replace('FormRequest', 'BaseRequest', $new_content);
            
            // file_put_contents( $file_path, $new_content );
    
        }
        
    // }

    // dd( $files );

    dd('done');
    // DB::table('assessment_sessions')->where('subject_id', '01hwdbq27cq1bqy94kc469wss0')->where('assessment_id', '01j0qw4vz5q1st84xnhykf9c9g')->get()->map( function($question){

    //    $correct =  preg_replace('/[\t\n\r\0\x0B\xc2\xa0]/', '', $question->student_answer);

    //    $correct = trim( $correct );

    //    $ques = QuestionModel::find( $question->question_id );
       
    //    $score = $ques->correct_answer == $question->student_answer ? $ques->question_score : 0;

    //    DB::table('assessment_sessions')->where('uuid', $question->uuid)->limit(1)->update(['score' => $score]);
    // //    dd( $question->correct_answer );

    // });
});
Route::get('/nnn', function(){

    // $questions =  Cache::get('questions_001');

    // dd( QuizContributorsEnum::getAllValues() );

    // // $response = Cache::put('questions_001', $response);

  
    $subject = SubjectModel::find('01j3z1r74j5f48qmkgyxmbtd5e')->subject_name;

    $assessment = AssessmentModel::find('01htyjxazcnqtfcc12nz4h22cp');

    $questions = DB::table('assessment_questions')
                    ->where( function($query){
                        $query->where('assessment_questions.assessment_id', '01htyjxazcnqtfcc12nz4h22cp')
                              ->where('assessment_questions.subject_id', '01htyjzz2nst0xxbkwbez2a5nk')
                              ->where('assessment_questions.class_id', '01HPRNPJ9EHM1VPMHQQPCKAXM3');
                    })
                    
                    ->join('questions', 'questions.uuid', '=', 'assessment_questions.question_id')
                    ->select('questions.question', 'questions.options', 'questions.correct_answer', 'questions.uuid as question_id')
                    ->get();
                    

    $questions = ( new GetAssessmentQuestionsFormatter( $questions, withSectionGrouping: false, withCorrectAnswers: true) )->toArray( request() ) ;

    // $questions = collect($questions)->chunk(5)->map( fn($question) => json_encode( array_values( $question->toArray() ) ) )->take(1)->toArray()[0];

    

    $questions = json_encode($questions[9]);
   
    // dd( $questions );

    $data = Http::timeout(12000)->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key=AIzaSyA1KsHYySPS1NwV0_moXBQyJ-Rw7_N16xg', [
        "contents" => [[
            "role"  => "user",
            "parts" => [
                [
                    "text" => "You are a knowledge engineer tasked with creating variations of a quiz question. You are given a single JSON object representing a quiz question with the following structure:
                                {
                                'question_id': 'string',
                                'question': 'string',
                                'options': ['string', 'string', ...],
                                'correct_answer': 'string' 
                                }
                            
                                Your task is to generate an array of 22 JSON objects, each containing a unique, but related question to the original one. The questions should be directly related to either the original question's subject matter which is {$subject} or its correct answer. The new questions should also:
                                Maintain the same educational intent as the original question: Test the student's understanding of the relevant concept, principle, or fact.
                                Maintain the original question_id: The new questions should keep the same question_id as the original question.
                                Be rephrased to be unique: Avoid repeating the original question's wording.
                                Have a unique set of options: Ensure each new question has a unique set of options that are not identical to any other question's options.
                                Have a different correct answer: The correct answer should not be the same as the original question's correct answer.
                                Focus on logical connections: Each question and its options should be logically linked to either the original question or the correct answer. This means that new questions should explore aspects of the topic, related concepts, or alternative explanations that are relevant to the original question.
                                
                                Input: {$questions}
                                
                                Output: Provide the array of 22 new JSON objects in the same format as the original, ensuring the question_id remains the same for each. Make sure to prioritize clarity, accuracy, and logical connections between questions and options.
                                Important: Generate exactly 22 new questions from the input question.
                                "
                ]
            ]
        ]
    ],
    "generationConfig" => [
            "temperature" => 1,
            "top_p" => 0.95,
            "top_k" => 64,
            "max_output_tokens" => 8192,
            "response_mime_type" => "application/json",
        ]
    ]);

    $response = $data->json();

    
    
    $response =  $data['candidates'][0]['content']['parts'][0]['text'];
    
    // dd( $response );
    dd( json_decode($response, true ) );
    
    $response = Cache::put('questions_001', $response);
    

    $response = Cache::put('questions_001', $response);

    $questions =  Cache::get('questions_001');


    $questions = json_decode($questions, true );

    $questions = collect($questions)->map( function($question){

        $questionId = explode('_', $question['question_id']);

        $question['question_id'] = $questionId[0];

        return $question;

    })->toArray();


    dd( $questions );

    $assessment = AssessmentModel::latest()->first();

    return redirect("/cbt/$assessment->assessment_code"); 
    
});

Route::middleware(['auth'])->group(function(){

    Route::get('/students/check-in/{assessment:assessment_code}', fn(AssessmentModel $assessment) => Inertia::render('CBT/CheckIn/Index', ['assessmentId' => $assessment->uuid]) );

    Route::get('/dashboard', fn() => Inertia::render('Dashboard/Index') );

    //Settings
    Route::get('/settings', fn() => Inertia::render('CBT/Settings/Index') );
    
    //Assessments


    //Stanalone Assessments
 

    //Termly Assessment Question Bank
    Route::get('/assessments/termly/question_banks/{assessment:uuid}', fn(AssessmentModel $assessment) => Inertia::render('CBT/Assessment/Question_Banks/Termly/page/Index', ['assessmentId' => $assessment->uuid, 'assessmentTitle' => Str::headline($assessment->title) ]) );
    Route::get('/assessments/termly/question_bank/create/{assessment:uuid}', fn(AssessmentModel $assessment) => Inertia::render('CBT/Assessment/Question_Banks/Termly/page/Create', ['assessmentId' => $assessment->uuid, 'assessmentTitle' => Str::headline($assessment->title) ]) );
    
    Route::get('/assessments/termly/question_bank/edit/{question_bank:uuid}', function(QuestionBankModel $question_bank){
        $assessment = AssessmentModel::find( $question_bank->assessment_id );
        return Inertia::render('CBT/Assessment/Question_Banks/Termly/page/Edit', ['assessmentId' => $assessment->uuid, 'assessmentTitle' => Str::headline($assessment->title), 'subjectId' => $question_bank->subject_id, 'questionBankId' => $question_bank->uuid  ]);
    } );

    //Questions Banks
    Route::get('/assessments/question_bank/sections/{question_bank:uuid}', function(QuestionBankModel $question_bank) {
        $assessment = AssessmentModel::find( $question_bank->assessment_id );
        return Inertia::render('CBT/Assessment/Question_Banks/shared/page/CreateSection', ['assessmentId' => $assessment->uuid, 'assessmentTitle' => Str::headline($assessment->title), 'questionBankId' => $question_bank->uuid]);
    } );

    Route::get('/assessment/questions/question-bank/{question_bank:uuid}', function(QuestionBankModel $question_bank){

        $assessment = AssessmentModel::find( $question_bank->assessment_id );

        if( $assessment->is_standalone ) {

            return Inertia::render('CBT/Assessment/Question_Banks/shared/page/Question', [ 'questionBankId' => $question_bank->uuid, 'isAssessmentQB' => $question_bank->is_assessment_question_bank, 'assessmentId' => $assessment->uuid, 'assessmentTitle' => Str::headline($assessment->title), 'subjectId' => $question_bank->subject_id ] );

        }

        $subject = SubjectModel::find( $question_bank->subject_id );

        $classes = collect( json_decode( $question_bank->classes, true ) )->flatMap( fn($class) => [ Str::headline(ClassModel::firstWhere('class_code', $class)->class_name) ] )->toArray();

        $classes = implode(' | ', $classes);

        return Inertia::render('CBT/Assessment/Question_Banks/shared/page/Question', [ 'questionBankId' => $question_bank->uuid, 'isAssessmentQB' => $question_bank->is_assessment_question_bank, 'assessmentId' => $assessment->uuid, 'questionBankClasses' => $classes, 'assessmentTitle' => Str::headline($assessment->title), 'subjectTitle' => Str::headline($subject->subject_name), 'subjectId' => $question_bank->subject_id ] );

    } );


    //Assessment Results
    Route::get('/assessments/results/s/{assessment:uuid}', function( AssessmentModel $assessment ) {
        if( ! $assessment->is_standalone ) abort(404);
        return Inertia::render('CBT/Assessment/standalone/results/Index', [ 'assessmentId' => $assessment->uuid, 'assessmentTitle' => Str::headline($assessment->title) ] );
    } );

    Route::get('/assessments/results/t/{assessment:uuid}', function( AssessmentModel $assessment ) {
        if( $assessment->is_standalone ) abort(404);
        return Inertia::render('CBT/Assessment/Termly/Results/page/Index', [ 'assessmentId' => $assessment->uuid, 'assessmentTitle' => Str::headline($assessment->title) ] );
    } );

    Route::get('/assessments/student/result/{student}/{assessment:uuid}', function($student, AssessmentModel $assessment ) {
        if( $assessment->is_standalone ) abort(404);
        return Inertia::render('CBT/Assessment/Termly/Results/page/Result', [ 'assessmentId' => $assessment->uuid, 'assessmentTitle' => Str::headline($assessment->title), 'studentId' => $student ] );
    } );

    //Assessment Types
    Route::get('/assessment-types', fn() => Inertia::render('CBT/Assessment_Types/Index') );

    //Questions
    Route::get('/questions/create/s/{assessment:uuid}', function(AssessmentModel $assessment){

        if( ! $assessment->is_standalone ) abort(404);

        return Inertia::render('CBT/Questions/Create', ['assessmentId' => $assessment->uuid, 'title' => Str::headline($assessment->title) ] );
    } );

    Route::get('/questions/create/t/{assessment:uuid}/{subject}/{class}', fn(AssessmentModel $assessment, $subject, $class) => Inertia::render('CBT/Questions/page/Create', ['assessmentId' => $assessment->uuid, 'subjectId' => $subject, 'classId' => $class, 'assessmentTitle' => Str::headline($assessment->title), 'subjectTitle' => Str::headline(SubjectModel::find($subject)->subject_name), 'questionBankClasses' => Str::headline(ClassModel::firstWhere('class_code', $class)->class_name)  ]) );
    
    

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
    Route::get('/academic-sessions', fn() => Inertia::render('SchoolManager/Sessions/page/Index') );
    Route::get('/academic-session/{session}', fn(AcademicSessionModel $session) => Inertia::render('SchoolManager/Sessions/page/Session', ['sessionId' => $session->uuid, 'sessionTitle' => $session->session]) );

    //Terms
    Route::get('/terms', fn() => Inertia::render('SchoolManager/Terms/Index') );

    //Results
    Route::get('/results/upload', fn() => Inertia::render('ResultManager/Upload/pages/Index') );
    Route::get('/results/upload-session', fn() => Inertia::render('ResultManager/Upload/pages/Upload') );


    //Result Templates
    Route::get('/result-templates', fn() => Inertia::render('ResultManager/Template/page/Index') );
});



Route::middleware(['auth'])->group(function(){

    Route::get('/teacher/dashboard', fn() => Inertia::render('CBT/Teacher/Dashboard') );

    Route::get('/teacher/subject-topics', fn() => Inertia::render('CBT/Teacher/SubjectTopics') );
    
    Route::get('/teacher/class-subjects/{class:class_code}', fn(ClassModel $class) => Inertia::render('CBT/Teacher/Subjects', ['classCode' => $class->class_code]) );
    
    Route::get('/teacher/create-question-bank', fn() => Inertia::render('CBT/Teacher/QuestionsIndex') );

    Route::get('/teacher/create-question-bank/classes/{question_bank:uuid}', fn(QuestionBankModel $questionBank) => Inertia::render('CBT/Teacher/QuestionBankClasses', [ 'questionBankId' => $questionBank->uuid ]) );
    Route::get('/teacher/create-question-bank/sections/{question_bank:uuid}', fn(QuestionBankModel $questionBank) => Inertia::render('CBT/Teacher/QuestionBankSections', [ 'questionBankId' => $questionBank->uuid ]) );
   
    Route::get('/teacher/questions/{question_bank:uuid}', fn(QuestionBankModel $questionBank) => Inertia::render('CBT/Teacher/CreateQuestions', [ 'questionBankId' => $questionBank->uuid, 'assessmentId' => AssessmentModel::find($questionBank->assessment_id)->uuid, 'subjectId' => $questionBank->subject_id  ]) );

});

// //CBT
Route::middleware(['auth:student', 'cbt', 'cbt.session'])->group(function() {

    Route::get('/completed/cbt/{assessment:uuid}', fn(AssessmentModel $assessment) => Inertia::render('CBT/Exams/Complete', [ 'assessmentId' => $assessment->uuid, 'assessmentCode' => $assessment->assessment_code ] ) );

    Route::get('/cbt/{assessment:assessment_code}/s', fn(AssessmentModel $assessment) => Inertia::render('CBT/Exams/Standalone', [ 'assessmentId' => $assessment->uuid ]) ) ;
   
    Route::get('/sse/cbt/save-session/student/{assessment:uuid}', [ ExamController::class, 'examSessionTimer' ]);
    
    Route::get('/cbt/{assessment:assessment_code}/t', fn(AssessmentModel $assessment) => Inertia::render('CBT/Exams/Termly/page/Index', [ 'assessmentId' => $assessment->uuid, 'assessmentTitle' => Str::headline($assessment->title), 'assessmentCode' => $assessment->assessment_code  ]) ) ;

    Route::get('/cbt/{assessment:uuid}/t/i', fn(AssessmentModel $assessment) => Inertia::render('CBT/Exams/Termly/page/Exam', [ 'assessmentId' => $assessment->uuid, 'assessmentCode' => $assessment->assessment_code ]) ) ;  
});









