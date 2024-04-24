<?php

namespace App\Modules\CBT\Models;

use App\Modules\SchoolManager\Models\AcademicSessionModel;
use App\Modules\SchoolManager\Models\ClassModel;
use App\Modules\SchoolManager\Models\SubjectModel;
use App\Modules\SchoolManager\Models\TermModel;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AssessmentModel extends Model
{
    use HasFactory, HasUlids;

    protected $primaryKey = 'uuid';

    protected $table = 'assessments';

    protected $guarded = ['uuid'];

    public function questions()
    {
        return $this->belongsToMany(QuestionModel::class, 'assessment_questions', 'assessment_id', 'question_id')->withPivot(['subject_id', 'class_id', 'uuid', 'section_id'])->withTimestamps();
    }

    public function assignQuestion($question_id, $subject_id = null, $class_id = null, $sectionId = null)
    {
        $class_id = ClassModel::firstWhere('class_code', $class_id)?->uuid;
        $sectionId = SectionModel::firstWhere('uuid', $sectionId)?->uuid;
        
        return $this->questions()->syncWithoutDetaching([ $question_id => [ 'subject_id' => $subject_id, 'class_id' => $class_id, 'uuid' => Str::ulid(), 'section_id' => $sectionId ]]);
    }

    public function assignQuestions(array $question_ids, $subject_id = null, $class_id = null, $sectionId = null)
    {
        $class_id = ClassModel::firstWhere('class_code', $class_id)?->uuid;
        $sectionId = SectionModel::firstWhere('uuid', $sectionId)?->uuid;
        
        $data = collect($question_ids)->map( fn($question_id) => ['question_id' => $question_id, 'subject_id' => $subject_id, 'class_id' => $class_id, 'uuid' => Str::ulid(), 'section_id' => $sectionId, 'assessment_id' => $this->uuid ])->toArray();

        $que = DB::table('assessment_questions')->where( fn($query) => $query->whereIn('question_id', $question_ids)->where('class_id', $class_id)->where('assessment_id', $this->uuid)->where('subject_id', $subject_id)->where('section_id', $sectionId) )->delete();
        
        return DB::table('assessment_questions')->insert( $data );
 
    }

    public function unAssignQuestion($question_id, $class_id = null, $subject_id = null)
    {
        $question_id = QuestionModel::firstWhere('uuid', $question_id)->uuid;
       
        if( $this->is_standalone ){

            return $this->questions()->detach($question_id);

        }else{

            $class_id = ClassModel::firstWhere('class_code', $class_id)->uuid;

            return DB::table('assessment_questions')->where( fn($query) => $query->where('assessment_questions.question_id', $question_id)->where('assessment_questions.subject_id', $subject_id)->where('assessment_questions.class_id', $class_id) )->limit(1)->delete();
        }
    }

    public function classes()
    {
        return $this->belongsToMany(ClassModel::class, 'assessment_classes', 'assessment_id', 'class_id');
    }

    public function addClassesToAssessment($classes)
    {
        $this->classes()->detach();

        foreach( $classes as $class ){
            DB::table('assessment_classes')->insert(['uuid' => Str::ulid(), 'assessment_id' => $this->uuid, 'class_id' => $class ]);
        }
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
                    ->withPivot(['class_id', 'start_date', 'end_date', 'assessment_duration', 'is_published']);
    }

    public function addSubject(Collection $data)
    {
        $data->each(function($subject, $key) {

            DB::table('assessment_subjects')
                ->insert(
                    [
                        'uuid'                  => $subject['id'] ?? Str::ulid(),
                        'assessment_id'         => $this->uuid, 
                        'subject_id'            => $key, 
                        'is_published'          => $subject['is_published'] === 'Published' ? true : false, 
                        'class_id'              => $subject['class_id'],
                        'assessment_duration'   => $subject['assessment_duration'],
                        'start_date'            => $subject['start_date'],
                        'end_date'              => $subject['end_date'],
                    ]);
        });

        return ;
    }
}
