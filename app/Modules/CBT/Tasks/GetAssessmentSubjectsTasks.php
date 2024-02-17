<?php

namespace App\Modules\CBT\Tasks;

use App\Contracts\BaseTasks;
use Illuminate\Support\Facades\DB;

class GetAssessmentSubjectsTasks extends BaseTasks{

    public function getSubjects()
    {
        $subjects = DB::table('assessment_subjects')->where('assessment_id', $this->item['assessment']->uuid)
                        ->join('subjects', 'subjects.uuid', '=', 'assessment_subjects.subject_id')
                        ->select('subjects.uuid as subjectId', 'subjects.subject_name as subjectName', 'subjects.subject_code as subjectCode', 'assessment_subjects.class_id as classId', 'assessment_subjects.assessment_duration as duration', 'assessment_subjects.start_date as startDate', 'assessment_subjects.end_date as endDate', 'assessment_subjects.is_published as published');

        if( isset($this->item['classId']) ){

            $subjects->where('assessment_subjects.class_id', $this->item['classId'] );
        }
        
        $subjects = $subjects->get()->unique('subjectCode')->toArray();

        return new static( $subjects );
    }
    
}