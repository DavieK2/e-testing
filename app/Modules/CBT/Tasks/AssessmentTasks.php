<?php

namespace App\Modules\CBT\Tasks;

use App\Contracts\BaseTasks;
use App\Models\User;
use App\Modules\CBT\Enums\QuizContributorsEnum;
use App\Modules\CBT\Enums\QuizTakersEnum;
use App\Modules\CBT\Models\AssessmentModel;
use App\Modules\UserManager\Models\RoleModel;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class AssessmentTasks extends BaseTasks {

    protected AssessmentModel|null $assessment = null;

    public function storeAssessmentToDatabase() : static
    {
        $required = ['assessmentTypeId', 'title', 'isStandalone'];

        if( $this->item['isStandalone'] == false ) {
            $required[] = 'academicSessionId';
            $required[] = 'schoolTermId';
        }

        $filter = array_intersect( $required, array_keys($this->item) );

        if( empty($filter) ) throw ValidationException::withMessages(['message' => 'One or more required field is missing']);

        $assessment_id = Str::random(8);

        $assessment = AssessmentModel::create(['assessment_code' =>  $assessment_id , ...$this->getAssessmentData() ]);

        return new static([ ...$this->item, 'assessmentId' => $assessment->uuid, 'isStandalone' => $assessment->is_standalone ? true : false ]);

    }

    public function addAssessmentClasses() : static
    {
        if( ! $this->assessment instanceof AssessmentModel ) throw new Exception("The assessment should be an instance of assessment model");
                
        $this->assessment->addClassesToAssessment( $this->item['classes'] );

        return new static( $this->item );

    }

    public function addSubjectsToAssessment() : static
    {
        if( ( ! isset($this->item['subjects']) ) && ( ! isset($this->item['assessmentId']) ) ) throw ValidationException::withMessages(['message' => 'One or more required field is missing']);

        $assessment = $this->getAssessment();

        $classes = collect( $this->item['subjects'] );
        
        $assessment->subjects()->detach();

        $assessment_subjects = collect();

        $classes->each( fn( $subjects) => collect($subjects)->each( fn( $subject ) => $assessment_subjects->push( $subject ) ) );


        $assessment_subjects = $assessment_subjects->map( function($subject) use($assessment) {

            return ['uuid' => ( $subject['id'] ?? Str::ulid() ), 'is_published' => ($subject['published']), 'class_id' => $subject['classId'], 'start_date' => $subject['startDate'], 'end_date' => $subject['endDate'], 'assessment_duration' => $subject['duration'] * 60, 'assessment_id' => $assessment->uuid, 'subject_id' => $subject['subjectId'] ];

        })->toArray();

        $assessment->addSubjects( $assessment_subjects );
        
        return new static( $this->item );
    }
    
    public function assessment( AssessmentModel $assessment ) : static
    {

        if( ! $assessment->exists ) throw new ModelNotFoundException();
        
        $this->assessment =  $assessment;

        return $this;
    }

    public function createQuiz() : static
    {
        $assessment = AssessmentModel::create([ 'is_standalone' => true, ...$this->getAssessmentData() ]);
        
        $this->assessment = $assessment;

        $this->item = [ ...$this->item, 'assessmentId' =>  $this->assessment->uuid ];

        return $this;
        
    }

    public function updateQuiz() : static
    {
        $this->assessment->update( $this->getAssessmentData() );
        
        return $this;

    }

    public function addContributors() : static
    {
        if( ! $this->assessment instanceof AssessmentModel ) throw new Exception("The assessment should be an instance of assessment model");
        
        $teachers = [];

        if( $this->assessment->contributor_type === QuizContributorsEnum::ALL_TEACHERS->value )
        {
            $teacher_role_id = RoleModel::where('role_name', 'teacher')->select('uuid')->first()->uuid;

            $teachers = User::where('role_id', $teacher_role_id)->pluck('uuid')->toArray();

        }

        if( $this->assessment->contributor_type === QuizContributorsEnum::SELECTED_TEACHERS->value )
        {
            $teachers = User::whereIn('uuid', $this->item['contributors'])->pluck('uuid')->toArray();
        }

        $this->assessment->addContibutorsToAssessment( $teachers );

        return $this;

    }

    public function addQuizTakers() : static
    {
        if( ! $this->assessment instanceof AssessmentModel ) throw new Exception("The assessment should be an instance of assessment model");

        if( $this->assessment->quiz_taker_type === QuizTakersEnum::SELECTED_CLASSES->value )
        {
            $this->assessment->addClassesToAssessment( $this->item['quizTakers'] );
        }

        if( $this->assessment->quiz_taker_type === QuizTakersEnum::SELECTED_STUDENTS->value )
        {
            $this->assessment->addStudentsToAssessment( $this->item['quizTakers'] );
        }
        
        return $this;
    }

    public function getQuizContributors()
    {
        if( ! $this->assessment instanceof AssessmentModel ) throw new Exception("The assessment should be an instance of assessment model");

        $query = DB::table('assessment_users')
                    ->where('assessment_id', $this->assessment->uuid)
                    ->join('users', 'users.uuid', '=', 'assessment_users.user_id')
                    ->select('users.*');

        return new static( $query );

    }

    public function getQuizTakers()
    {
        if( ! $this->assessment instanceof AssessmentModel ) throw new Exception("The assessment should be an instance of assessment model");

        $query = [];

        if( $this->assessment->quiz_taker_type === QuizTakersEnum::SELECTED_CLASSES->value )
        {
            $query = DB::table('assessment_classes')
                        ->where('assessment_id', $this->assessment->uuid)
                        ->join('classes', 'classes.uuid', '=', 'assessment_classes.class_id')
                        ->select('classes.uuid', 'classes.class_code', 'classes.class_name');
        }

        if( $this->assessment->quiz_taker_type === QuizTakersEnum::SELECTED_STUDENTS->value )
        {
            $query = DB::table('assessment_students')
                        ->where('assessment_id', $this->assessment->uuid)
                        ->join('student_profiles', 'student_profiles.uuid', '=', 'assessment_students.student_profile_id')
                        ->select('student_profiles.*');
        }

        return new static( $query );

    }

    protected function getAssessmentData() : array
    {
        return [
            'title'                     => $this->item['title'],
            'assessment_code'           => $this->assessment?->assessment_code ?? Str::random(8),
            'assessment_type_id'        => $this->item['assessmentTypeId'],
            'assessment_duration'       => intval( $this->item['duration'] ) * 60,
            'start_date'                => $this->item['startDate'],
            'end_date'                  => $this->item['endDate'],
            'description'               => $this->item['description'] ?? null,
            'quiz_taker_type'           => $this->item['quizTakerType'] ?? null,
            'contributor_type'          => $this->item['contributorType'] ?? null,
            'should_display_results'    => $this->item['shouldDisplayResults'] ?? null,
            'should_shuffle_questions'   => $this->item['shouldShuffleQuestions'] ?? null,
            'grade_with_assessment_type_max_score' => $this->item['shouldGradeWithAssessmentTypeMaxScore']
        ];
    }


    public function getAssessments() : BaseTasks
    {
        $assessments = AssessmentModel::query()
                                     ->leftJoin('assessment_types', 'assessment_types.uuid', '=', 'assessments.assessment_type_id')
                                     ->leftJoin('academic_sessions', 'academic_sessions.uuid', '=', 'assessments.academic_session_id')
                                     ->leftJoin('school_terms', 'school_terms.uuid', '=', 'assessments.school_term_id')
                                     ->select('assessments.uuid', 'assessments.assessment_code', 'assessments.title', 'assessments.is_published', 'assessments.is_standalone','assessments.start_date', 'assessments.end_date','assessments.description', 'assessments.assessment_duration', 'assessment_types.type', 'academic_sessions.session', 'school_terms.term');
        
        return new static( [...$this->item, 'query' => $assessments ]);
    }

    public function getAssignedAssesments() : BaseTasks
    {
        $assigned_assessments = DB::table('assessment_users')
                                    ->join('assessments', 'assessments.uuid', '=', 'assessment_users.assessment_id')
                                    ->where('assessment_users.user_id', request()->user()->uuid);

        return new static( [...$this->item, 'query' => $assigned_assessments ]);
    }

    public function getAssessmentClasses()
    {
        $classes = $this->assessment->classes()->select('classes.uuid', 'classes.class_code', 'classes.class_name');

        return new static( ['query' => $classes ]);
    }

    public function getSubjects()
    {
        $subjects = DB::table('assessment_subjects')->where('assessment_id', $this->assessment->uuid)
                        ->join('subjects', 'subjects.uuid', '=', 'assessment_subjects.subject_id')
                        ->select('subjects.uuid as subjectId', 'subjects.subject_name as subjectName', 'subjects.subject_code as subjectCode', 'assessment_subjects.class_id as classId', 'assessment_subjects.assessment_duration as duration', 'assessment_subjects.start_date as startDate', 'assessment_subjects.end_date as endDate', 'assessment_subjects.is_published as published', 'assessment_subjects.uuid as id');

        
        if( isset($this->item['classId']) ) {

            $subjects->where('assessment_subjects.class_id', $this->item['classId'] );

            $subjects = $subjects->get()->map( fn($subject) => [
            
                'subjectId'     => $subject->subjectId,
                'subjectName'   => $subject->subjectName,
                'subjectCode'   => $subject->subjectCode,
                'classId'       => $subject->classId,
                'published'     => $subject->published,
    
            ]);

            return new static( $subjects );
        }
        
        $subjects = $subjects->get()->map( fn($subject) => [
            
            'id'            => $subject->id,
            'subjectId'     => $subject->subjectId,
            'subjectName'   => $subject->subjectName,
            'subjectCode'   => $subject->subjectCode,
            'classId'       => $subject->classId,
            'duration'      => ( $subject->duration ) / 60,
            'startDate'     => $subject->startDate,
            'endDate'       => $subject->endDate,
            'published'     => $subject->published,

        ])->groupBy('classId')
          ->map( fn($subject) => $subject->groupBy('subjectId')->mapWithKeys(fn($subject, $key) => [ $key => $subject[0] ])->toArray() )
          ->toArray();

        return new static( $subjects );
    }

    public function getPublishedAssessments()
    {
        $assessment = $this->assessment->where(fn($query) => $query->where('assessments.is_published', true)->where('is_standalone', false))->select('assessments.uuid as assessmentId', 'assessments.title');

        return new static( [ ...$this->item, 'query' => $assessment ]);
    }

    public function updateAssessment()
    {


        dd('Needs Work');
        
        // if( isset($this->item['publish']) ){

        //     $this->assessment->update([ 'is_published' => $this->item['publish'] ]);

        // }else{

        //     $task->getAssessment()->update($task->getAssessmentData());
        // }
       
        // return new static( $this->item );

    }
}