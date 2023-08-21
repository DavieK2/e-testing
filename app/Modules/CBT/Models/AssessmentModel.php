<?php

namespace App\Modules\CBT\Models;

use App\Modules\SchoolManager\Models\AcademicSessionModel;
use App\Modules\SchoolManager\Models\ClassModel;
use App\Modules\SchoolManager\Models\SubjectModel;
use App\Modules\SchoolManager\Models\TermModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentModel extends Model
{
    use HasFactory;

    protected $table = 'assessments';

    protected $guarded = ['id'];

    public function questions()
    {
        return $this->belongsToMany(QuestionModel::class, 'assessment_questions', 'assessment_id', 'question_id')->withPivot(['subject_id']);
    }

    public function assignQuestion($question_id, $subject_id = null)
    {
        $question_id = QuestionModel::firstWhere('uuid', $question_id)->id;
        
        return $this->questions()->syncWithoutDetaching([ $question_id => [ 'subject_id' => $subject_id ]]);
    }

    public function unAssignQuestion($question_id, $subject_id = null)
    {
        $question_id = QuestionModel::firstWhere('uuid', $question_id)->id;
        return $this->questions()->detach($question_id);
    }

    public function classes()
    {
        return $this->belongsToMany(ClassModel::class, 'assessment_classes', 'assessment_id', 'class_id');
    }

    public function addClassesToAssessment($classes)
    {
        return $this->classes()->sync($classes);
    }

    public function assessmentType()
    {
        return $this->belongsTo(AssessmentTypeModel::class, 'assessment_type_id');
    }

    public function session()
    {
        return $this->belongsTo(AcademicSessionModel::class, 'academic_session_id');
    }

    public function term()
    {
        return $this->belongsTo(TermModel::class, 'school_term_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(SubjectModel::class, 'assessment_subjects', 'assessment_id', 'subject_id')
                    ->withPivot(['class_id', 'start_date', 'end_date', 'assessment_duration']);
    }

    public function addSubject($subject_id, $class_id, $start_date, $end_date, $duration)
    {
        return $this->subjects()->syncWithoutDetaching([$subject_id => ['class_id' => $class_id, 'start_date' => $start_date, 'end_date' => $end_date, 'assessment_duration' => $duration ]]);
    }
}
