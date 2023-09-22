<?php

namespace App\Modules\CBT\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\CBT\Models\AssessmentModel;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class CreateAssessmentTasks extends BaseTasks {

    public function storeAssessmentToDatabase()
    {
        $required = ['assessmentTypeId', 'title', 'isStandalone'];

       

        if( $this->item['isStandalone'] == false ) {
            $required[] = 'academicSessionId';
            $required[] = 'schoolTermId';
        }

        $filter = array_intersect( $required, array_keys($this->item) );

        if( empty($filter) ) throw ValidationException::withMessages(['message' => 'One or more required field is missing']);

        $assessment_id = Str::random(8);

        $assessment = AssessmentModel::create(['uuid' =>  $assessment_id , ...$this->getAssessmentData() ]);

        return new static([ ...$this->item, 'assessmentId' => $assessment->uuid, 'isStandalone' => $assessment->is_standalone ? true : false ]);

    }

    public function addAssessmentClasses()
    {
       
        if( ( ! isset($this->item['classes']) ) && ( ! isset($this->item['assessmentId']) ) ) throw ValidationException::withMessages(['message' => 'One or more required field is missing']);
        
        $classes = collect($this->item['classes'])->pluck('id')->toArray();
        
        $this->getAssessment()->addClassesToAssessment( $classes );

        return new static( $this->item );

    }

    public function addSubjectsToAssessment()
    {
        if( ( ! isset($this->item['subjects']) ) && ( ! isset($this->item['assessmentId']) ) ) throw ValidationException::withMessages(['message' => 'One or more required field is missing']);

        $assessment = $this->getAssessment();

        $data = collect($this->item['subjects'])->groupBy('classId');

        $assessment->subjects()->detach();

        $data->each(function($subject) use($assessment) {

            $subjectData = collect($subject)->mapWithKeys( fn($subject) => [ $subject['subjectId'] => ['class_id' => $subject['classId'], 'start_date' => $subject['startDate'], 'end_date' => $subject['endDate'], 'assessment_duration' => $subject['duration'] * 60 ] ]);

            $assessment->addSubject( $subjectData );

        });
        
        return new static( $this->item );
    }
    
    public function getAssessment()
    {
        $assessment = AssessmentModel::firstWhere('uuid', $this->item['assessmentId']);

        if( is_null($assessment) ) throw ValidationException::withMessages(['message' => 'Assessment No Found']);

        return $assessment;
    }

    public function getAssessmentData()
    {
        return [
            'title' => $this->item['title'],
            'is_standalone' => $this->item['isStandalone'],
            'assessment_type_id' => $this->item['assessmentTypeId'],
            'academic_session_id' => $this->item['academicSessionId'] ?? null,
            'school_term_id' => $this->item['schoolTermId'] ?? null,
            'assessment_duration' => intval( $this->item['duration'] ?? 0 ) * 60,
            'start_date' => $this->item['startDate'] ?? null,
            'end_date' => $this->item['endDate'] ?? null,
            'description' => $this->item['description'] ?? null
        ];
    }
}