<?php

namespace App\Modules\SchoolManager\Models;

use App\Modules\CBT\Models\AssessmentModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProfileModel extends Model
{
    use HasFactory;

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
        return $this->belongsToMany(AssessmentModel::class, 'assessment_sessions', 'student_profile_id', 'question_id' )->withPivot(['question_id', 'subject_id', 'student_answer', 'marked_for_review', 'score' ])->withTimestamps();
    }

    public function saveStudentResponse(AssessmentModel $assessment, $questionId, $studentAnswer, $markedForReview, $score, $subjectId = null )
    {
        return $this->assessmentSession()->syncWithoutDetaching([ $questionId => [ 'assessment_id' => $assessment->id, 'student_answer' => $studentAnswer, 'marked_for_review' => $markedForReview, 'score' => $score, 'subject_id' => $subjectId ] ]);
    }
}
