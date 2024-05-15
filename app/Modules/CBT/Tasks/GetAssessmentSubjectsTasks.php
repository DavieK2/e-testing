<?php

namespace App\Modules\CBT\Tasks;

use App\Contracts\BaseTasks;
use Illuminate\Support\Facades\DB;

class GetAssessmentSubjectsTasks extends BaseTasks {

    public function getSubjects()
    {
        $subjects = DB::table('assessment_subjects')->where('assessment_id', $this->item['assessment']->uuid)
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
    
}