<?php

namespace App\Modules\SchoolManager\Models;

use App\Modules\CBT\Models\AssessmentModel;
use App\Modules\CBT\Models\CheckInModel;
use App\Modules\CBT\Models\ExamResultsModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class StudentProfileModel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'student_profiles';

    protected $guarded = [];

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(SubjectModel::class, 'student_subjects', 'student_profile_id', 'subject_id');
    }

    public function assignSubject(array $subjects)
    {

        $this->subjects()->detach();

        foreach( $subjects as $subject ){

            DB::table('student_subjects')->insert( ['student_profile_id' => $this->id, 'subject_id' => $subject, 'uuid' => Str::ulid() ] );
        }
    }

    public function assessmentSession()
    {
        return $this->belongsToMany(AssessmentModel::class, 'assessment_sessions', 'student_profile_id', 'question_id' )->withPivot(['assessment_id', 'subject_id', 'student_answer', 'marked_for_review', 'score', 'uuid' ])->withTimestamps();
    }

    public function saveStudentResponse(AssessmentModel $assessment, $questionId, $studentAnswer, $markedForReview, $score, $subjectId = null )
    {
        $subjectId = SubjectModel::firstWhere('subject_code', $subjectId)?->id;
        
        $session = DB::table('assessment_sessions')->where(fn($query) => $query->where('student_profile_id', $this->id)
                                                                    ->where('assessment_id', $assessment->id)
                                                                    ->where('question_id',$questionId)
                                                                    ->where('subject_id', $subjectId)
        );

        if( $session->count() > 0) {

            $session->update([
                'student_answer'    => $studentAnswer, 
                'marked_for_review' => $markedForReview, 
                'score'             => $score, 
            ]);

        } else {

            DB::table('assessment_sessions')->insert(
                [
                    'uuid'              => Str::ulid(),
                    'student_profile_id' => $this->id, 
                    'assessment_id'     => $assessment->id, 
                    'question_id'       => $questionId,
                    'student_answer'    => $studentAnswer, 
                    'marked_for_review' => $markedForReview, 
                    'score'             => $score, 
                    'subject_id'        => $subjectId
                ] 
            );
        }

        // DB::table('assessment_sessions')->updateOrInsert(
        //     [ 'uuid' => $sessionId, 'student_profile_id' => $this->id, 'assessment_id' => $assessment->id, 'question_id' => $questionId, 'subject_id' => $subjectId ], 
        //     [
        //         'uuid' => Str::ulid(),
        //         'student_profile_id' => $this->id, 
        //         'assessment_id' => $assessment->id, 
        //         'question_id' => $questionId,
        //         'student_answer' => $studentAnswer, 
        //         'marked_for_review' => $markedForReview, 
        //         'score' => $score, 
        //         'subject_id' => $subjectId

        //     ] 
        // );

        return ;

    }
    
    public function checkIns()
    {
        return $this->hasOne(CheckInModel::class, 'student_checkins', 'student_profile_id');
    }

    public function results()
    {
        return $this->hasMany(ExamResultsModel::class, 'assessment_results', 'student_profile_id');
    }
}
