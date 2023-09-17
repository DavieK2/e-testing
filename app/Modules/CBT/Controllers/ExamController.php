<?php

namespace App\Modules\CBT\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\CBT\Features\GetAssessmentQuestionsFeature;
use App\Modules\CBT\Models\AssessmentModel;
use App\Modules\CBT\Models\CheckInModel;
use App\Modules\CBT\Models\ExamResultsModel;
use App\Modules\CBT\Models\QuestionModel;
use App\Modules\CBT\Requests\ExamSessionTimerRequest;
use App\Modules\CBT\Requests\GetAssessmentQuestionsRequest;
use App\Modules\CBT\Requests\GetStudentExamResponsesRequest;
use App\Modules\CBT\Requests\SaveStudentExamSessionResponsesRequest;
use App\Modules\CBT\Requests\StartStudentExamSessionRequest;
use App\Modules\CBT\Requests\SubmitStudentExamRequest;
use App\Modules\SchoolManager\Models\StudentProfileModel;
use App\Modules\SchoolManager\Models\SubjectModel;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Question\Question;

class 
ExamController extends Controller
{
    
    public function getAssessmentQuestions(AssessmentModel $assessment, GetAssessmentQuestionsRequest $request)
    {
        return $this->serve( new GetAssessmentQuestionsFeature($assessment), [ ...$request->validated(), 'user' => request()->user() ] );
    }

    public function startStudentStandaloneExamSession(AssessmentModel $assessment)
    {
        date_default_timezone_set('Africa/Lagos');

        $studentId = request()->user()->id;

        $student_session = ExamResultsModel::where('student_profile_id', $studentId)->where('assessment_id', $assessment->id)->first();

        $end_time = now()->addSeconds($assessment->assessment_duration)->toDateTimeString();
        $start_time = now()->toDateTimeString();

        $student_session->update([ 'start_time' => $start_time, 'end_time' => $end_time, 'has_started' => true ]);

        return response()->json(['timeLeft' => 'Success']);
    }

    public function getStudentStandaloneExamSession(AssessmentModel $assessment)
    {

        date_default_timezone_set('Africa/Lagos');

        $student = request()->user();

        $student_result = ExamResultsModel::firstOrCreate(['student_profile_id' => $student->id, 'assessment_id' => $assessment->id ],[
            'student_profile_id'    => $student->id,
            'assessment_id'        => $assessment->id,
            'time_remaining'       => $assessment->assessment_duration
        ]);

        $instructions = $assessment->description;
        $total_questions = $assessment->questions()->count();
        $total_marks = $assessment->questions()->sum('question_score');
        $duration = $assessment->assessment_duration;
        $assessment_title = $assessment->title;

        if( $student_result->has_started ){

            $end_time = now()->addSeconds($student_result->time_remaining)->toDateTimeString();

            $student_result->update([ 'end_time' => $end_time, 'tries' => intval($student_result->tries) - 1 ]);
           
            $time_remaining = $student_result->time_remaining;

        }else{

            $time_remaining = $duration;
        }

        return response()->json([
            'studentName'           => $student->first_name." ".$student->surname,
            'studentCode'           => $student->student_code,
            'studentPhoto'          => $student->profile_pic,
            'hasStarted'            => $student_result->has_started,
            'instructions'          => $instructions,
            'totalQuestions'        => $total_questions,
            'totalScore'            => $total_marks,
            'assessmentDuration'    => $duration,
            'assessmentTitle'       => $assessment_title,
            'remainingTime'         => intval($time_remaining),
            'remainingTries'        => $student_result->tries
        ]);     
        
    }


    public function examSessionTimer(AssessmentModel $assessment, ExamSessionTimerRequest $request)
    {
        date_default_timezone_set('Africa/Lagos');

        header("Cache-Control: no-store");
        header("Content-Type: text/event-stream");

        ob_end_flush();

        $studentId = auth()->guard('student')->user()->id;

        $data = $request->validated();

        if( $assessment->is_standalone ){

            $student_session = ExamResultsModel::where('student_profile_id', $studentId)->where('assessment_id', $assessment->id)->first();

        }else{

            $subjectId = SubjectModel::firstWhere('subject_code',$data['subjectId'] )->id;
            
            $student_session = ExamResultsModel::where('student_profile_id', $studentId)->where('assessment_id', $assessment->id)->where('subject_id', $subjectId)->first();
        }

        $end_time = $student_session->end_time;
        $start_time = now()->toDateTimeString();

        $time_remaining = strtotime($end_time) - strtotime($start_time);

        
        while ($time_remaining > 0) {
       
            echo 'data: '. $time_remaining . "\n\n";
           
            $time_remaining -- ;

            $student_session->update(['time_remaining' => $time_remaining]);
            // flush();
            ob_end_clean();

            if (connection_aborted()) break;

            sleep(1);
        }

        echo 'data: '. 0 . "\n\n";

        // flush();
        ob_end_flush();

    }

    public function getStudentExamSessionResponses(AssessmentModel $assessment, GetStudentExamResponsesRequest $request)
    {
        $studentId = request()->user()->id;

        $data = $request->validated();

        $student_responses = DB::table('assessment_sessions')
                                ->where(function($query) use($assessment, $studentId, $data){
                                    $query->where('assessment_sessions.student_profile_id', $studentId)
                                        ->where('assessment_sessions.assessment_id', $assessment->id);

                                    if( isset( $data['subjectId'] ) && $data['subjectId'] ){
                                        $subjectId = SubjectModel::firstWhere('subject_code',$data['subjectId'] )->id;
                                        $query->where('assessment_sessions.subject_id', $subjectId);
                                    }
                                })
                                ->join('questions', 'questions.id', '=', 'assessment_sessions.question_id')
                                ->select('assessment_sessions.student_answer as studentAnswer', 'assessment_sessions.marked_for_review as markedForReview', 'questions.uuid as questionId')
                                ->get();

        $student_responses = $student_responses->map( function($response) {

            $not_answered = ( is_null( $response->studentAnswer ) );

            return [
                'questionId'        => $response->questionId,
                'selectedAnswer'    => $response->studentAnswer,
                'markedForReview'   => $response->markedForReview,
                'notAnswered'       => $not_answered
            ];
        });

       return response()->json([
            'data' => $student_responses->toArray()
       ]);
    }

    public function saveStudentExamSessionAnswer(AssessmentModel $assessment, SaveStudentExamSessionResponsesRequest $request)
    {
        $student = request()->user();

        $data = $request->validated();

        $question = QuestionModel::firstWhere('uuid', $data['questionId']);

        $score = $data['studentAnswer'] == $question->correct_answer ? $question->question_score : 0;

        $student->saveStudentResponse($assessment, $question->id, $data['studentAnswer'], $data['markedForReview'], $score, $data['subjectId'] ?? null );

        return response()->json(['message' => 'Answer Saved']);

    }


    public function getStudentTermlyExamAssessments(AssessmentModel $assessment)
    {
        $student = request()->user();

        $student_class = $student->class_id;

        $student_subjects = $student->subjects()->get()->pluck('id')->toArray();

        $student_session = ExamResultsModel::whereIn('subject_id', $student_subjects)
                                            ->where('assessment_id', $assessment->id)
                                            ->where('student_profile_id', $student->id)
                                            ->where('has_submitted', true)
                                            ->get()
                                            ->pluck('subject_id')
                                            ->toArray();

        foreach ( $student_subjects as $key => $value ) {
           if( in_array( $value, $student_session ) ) unset( $student_subjects[$key] );    
        }

        $available_subjects = DB::table('assessment_subjects')
                                ->where( fn($query) => $query->whereIn('assessment_subjects.subject_id', $student_subjects)->where('assessment_subjects.class_id', $student_class) )
                                ->join('subjects', 'subjects.id', '=', 'assessment_subjects.subject_id')
                                ->select('assessment_subjects.assessment_duration as duration', 'subjects.subject_name as subjectName', 'subjects.subject_code as subjectCode')
                                ->get()
                                ->toArray();


       return response()->json([
            'data' => $available_subjects
       ]);

    }

    public function getStudentTermlyExamAssessmentSession(AssessmentModel $assessment, SubjectModel $subject)
    {
        date_default_timezone_set('Africa/Lagos');

        $student = request()->user();

        $assessment_subject = $assessment->subjects()->where('assessment_subjects.subject_id', $subject->id)->where('assessment_subjects.class_id', $student->class_id)->first();

        $student_result = ExamResultsModel::firstOrCreate(['student_profile_id' => $student->id, 'assessment_id' => $assessment->id, 'subject_id' => $subject->id ],[
                            'student_profile_id'    => $student->id,
                            'assessment_id'        => $assessment->id,
                            'subject_id'           => $subject->id,
                            'time_remaining'       => $assessment_subject->pivot->assessment_duration
        ]);

        $instructions = $assessment->description;
        $total_questions = $assessment->questions()->where(fn($query) => $query->where('assessment_questions.subject_id', $subject->id )->where('assessment_questions.class_id', $student->class_id))->count();
        $total_marks = $assessment->questions()->where(fn($query) => $query->where('assessment_questions.subject_id', $subject->id )->where('assessment_questions.class_id', $student->class_id))->sum('question_score');
        $duration = $assessment_subject->pivot->assessment_duration;
        $assessment_title = $assessment->title;

        if( $student_result->has_started ){

            $end_time = now()->addSeconds($student_result->time_remaining)->toDateTimeString();

            $student_result->update([ 'end_time' => $end_time, 'tries' => intval($student_result->tries) - 1 ]);
           
            $time_remaining = $student_result->time_remaining;

        }else{

            $time_remaining = $duration;
        }

        return response()->json([
            'studentName'           => $student->first_name." ".$student->surname,
            'studentCode'           => $student->student_code,
            'hasStarted'            => $student_result->has_started,
            'instructions'          => $instructions,
            'totalQuestions'        => $total_questions,
            'totalScore'            => $total_marks,
            'assessmentDuration'    => $duration,
            'assessmentTitle'       => "$assessment_title ($subject->subject_name)",
            'remainingTime'         => intval($time_remaining),
            'remainingTries'        => $student_result->tries
        ]);     
    }

    public function startStudentTermlyExamSession(AssessmentModel $assessment, SubjectModel $subject)
    {
        date_default_timezone_set('Africa/Lagos');

        $student= request()->user();

        $student_session = ExamResultsModel::where( fn($query) => $query->where('subject_id', $subject->id)
                                                                        ->where('assessment_id', $assessment->id)
                                                                        ->where('student_profile_id', $student->id)
                                                                  )->first();

        $assessment_subject = $assessment->subjects()->where('assessment_subjects.subject_id', $subject->id)->where('assessment_subjects.class_id', $student->class_id)->first();

        $end_time = now()->addSeconds( $assessment_subject->pivot->assessment_duration )->toDateTimeString();
        $start_time = now()->toDateTimeString();

        $student_session->update([ 'start_time' => $start_time, 'end_time' => $end_time, 'has_started' => true ]);

        return response()->json(['timeLeft' => 'Success']);
    }

    public function submitExam(AssessmentModel $assessment, SubmitStudentExamRequest $request)
    {
        $studentId = request()->user()->id;
        
        $data = $request->validated();

        if( $assessment->is_standalone ){

            $student_session = ExamResultsModel::where('student_profile_id', $studentId)->where('assessment_id', $assessment->id)->first();

        }else{

            $subjectId = SubjectModel::firstWhere('subject_code',$data['subjectId'] )->id;
            
            $student_session = ExamResultsModel::where('student_profile_id', $studentId)->where('assessment_id', $assessment->id)->where('subject_id', $subjectId)->first();
        }

        $url = $assessment->is_standalone ? url("/completed/cbt/$assessment->uuid") : url("/cbt/$assessment->uuid/t");

        $student_session->update(['has_submitted' => true ]);

        return response()->json(['message' => 'Success', 'url' => $url ]);

    }


    public function checkInStudentData()
    {        
        $data = request()->validate([
            'studentId' => 'required|exists:student_profiles,student_code',
        ]);

        $student = StudentProfileModel::firstWhere('student_code', $data['studentId']);

        return response()->json([
            'studentName'       =>     $student->first_name. " ". $student->surname,
            'studentCode'       =>     $student->student_code,
            'studentClass'      =>     $student->class->class_name,
            'studentPhoto'      =>     $student->profile_pic,
        ]);

    }

    public function checkInStudent(AssessmentModel $assessment)
    {
        date_default_timezone_set('Africa/Lagos');

        $data = request()->validate([
            'studentId' => 'required|exists:student_profiles,student_code',
        ]);

        $student = StudentProfileModel::firstWhere('student_code', $data['studentId'])->id;
        
        CheckInModel::updateOrCreate([ 'assessment_id' => $assessment->id, 'student_profile_id' => $student ], [
            'assessment_id' => $assessment->id,
            'student_profile_id' => $student,
            'checked_in_at' => now(),
            'checked_in_expires_at' => now()->endOfDay()
        ]);

        return response()->json(['Message' => 'Checked In']);

    }
}
