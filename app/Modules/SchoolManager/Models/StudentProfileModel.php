<?php

namespace App\Modules\SchoolManager\Models;

use App\Modules\CBT\Models\AssessmentModel;
use App\Modules\CBT\Models\CheckInModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class StudentProfileModel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'student_profiles';

    protected $guarded = ['id'];

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
        return $this->subjects()->sync( $subjects );
    }

    public function assessmentSession()
    {
        return $this->belongsToMany(AssessmentModel::class, 'assessment_sessions', 'student_profile_id', 'question_id' )->withPivot(['assessment_id', 'subject_id', 'student_answer', 'marked_for_review', 'score' ])->withTimestamps();
    }

    public function saveStudentResponse(AssessmentModel $assessment, $questionId, $studentAnswer, $markedForReview, $score, $subjectId = null )
    {
        $subjectId = SubjectModel::firstWhere('subject_code', $subjectId)?->id;
        
        DB::table('assessment_sessions')->updateOrInsert(
            ['student_profile_id' => $this->id, 'assessment_id' => $assessment->id, 'question_id' => $questionId, 'subject_id' => $subjectId ], 
            [
                'student_profile_id' => $this->id, 
                'assessment_id' => $assessment->id, 
                'question_id' => $questionId,
                'student_answer' => $studentAnswer, 
                'marked_for_review' => $markedForReview, 
                'score' => $score, 
                'subject_id' => $subjectId

            ] 
        );

        return ;

    }
    
    public function checkIns()
    {
        return $this->hasOne(CheckInModel::class, 'student_checkins', 'student_profile_id');
    }
}
