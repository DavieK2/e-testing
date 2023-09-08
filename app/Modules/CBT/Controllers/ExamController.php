<?php

namespace App\Modules\CBT\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\CBT\Features\GetAssessmentQuestionsFeature;
use App\Modules\CBT\Models\AssessmentModel;
use App\Modules\CBT\Models\ExamResultsModel;
use App\Modules\CBT\Models\QuestionModel;
use App\Modules\CBT\Requests\SaveStudentStandaloneExamSessionResponsesRequest;
use App\Modules\CBT\Requests\StartStudentExamSessionRequest;
use App\Modules\SchoolManager\Models\StudentProfileModel;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Question\Question;

class ExamController extends Controller
{
    
    public function getAssessmentQuestions(AssessmentModel $assessment)
    {
        return $this->serve( new GetAssessmentQuestionsFeature($assessment) );
    }

    public function startStudentStandaloneExamSession(AssessmentModel $assessment)
    {
        date_default_timezone_set('Africa/Lagos');

        $studentId = StudentProfileModel::first()->id;

        $student_session = ExamResultsModel::where('student_profile_id', $studentId)->where('assessment_id', $assessment->id)->first();

        $end_time = now()->addSeconds($assessment->assessment_duration)->toDateTimeString();
        $start_time = now()->toDateTimeString();

        $student_session->update([ 'start_time' => $start_time, 'end_time' => $end_time, 'has_started' => true ]);

        return response()->json(['timeLeft' => 'Success']);
    }

    public function getStudentStandaloneExamSession(AssessmentModel $assessment)
    {

        date_default_timezone_set('Africa/Lagos');

        $studentId = StudentProfileModel::first()->id;

        $student_result = ExamResultsModel::firstOrCreate(['student_profile_id' => $studentId, 'assessment_id' => $assessment->id ],[
                            'student_profile_id'    => $studentId,
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

            $student_result->update([ 'end_time' => $end_time]);
           
            $time_remaining = $student_result->time_remaining;

        }else{

            $time_remaining = $duration;
        }

        return response()->json([
            'hasStarted'            => $student_result->has_started,
            'instructions'          => $instructions,
            'totalQuestions'        => $total_questions,
            'totalScore'            => $total_marks,
            'assessmentDuration'    => $duration,
            'assessmentTitle'       => $assessment_title,
            'remainingTime'         => intval($time_remaining)
        ]);     
        
    }


    public function getStudentStandaloneExamSessionTime(AssessmentModel $assessment)
    {
        date_default_timezone_set('Africa/Lagos');

        header("Cache-Control: no-store");
        header("Content-Type: text/event-stream");

        ob_end_flush();

        $studentId = StudentProfileModel::first()->id;

        $student_session = ExamResultsModel::where('student_profile_id', $studentId)->where('assessment_id', $assessment->id)->first();

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

    public function getStudentStandaloneExamSessionResponses(AssessmentModel $assessment)
    {
        $studentId = StudentProfileModel::first()->id;

        $student_responses = DB::table('assessment_sessions')->where(fn($query) => $query->where('assessment_sessions.student_profile_id', $studentId)->where('assessment_sessions.assessment_id', $assessment->id) )
                                ->join('questions', 'questions.id', '=', 'assessment_sessions.question_id')
                                ->select('assessment_sessions.student_answer as studentAnswer', 'assessment_sessions.marked_for_review as markedForReview', 'questions.uuid as questionId')
                                ->get();

        $student_responses = $student_responses->flatMap( function($response) {

            $not_answered = (! $response->marked_for_rewiew && is_null( $response->student_answer ) );
        });

        dd($student_responses);
    }

    public function saveStudentStandaloneExamSessionAnswer(AssessmentModel $assessment, SaveStudentStandaloneExamSessionResponsesRequest $request)
    {
        $student = StudentProfileModel::first();

        $data = $request->validated();

        $question = QuestionModel::firstWhere('uuid', $data['questionId']);

        $score = $data['studentAnswer'] == $question->correct_answer ? $question->question_score : 0;

        $student->saveStudentResponse($assessment, $question->id, $data['studentAnswer'], $data['markedForReview'], $score );

        return response()->json(['message' => 'Answer Saved']);

    }
}
