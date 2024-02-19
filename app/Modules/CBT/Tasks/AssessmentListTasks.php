<?php

namespace App\Modules\CBT\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\CBT\Models\AssessmentModel;

class AssessmentListTasks extends BaseTasks{

    
    public function getAssessments()
    {
        $assessments = AssessmentModel::query()
                                     ->leftJoin('assessment_types', 'assessment_types.uuid', '=', 'assessments.assessment_type_id')
                                     ->leftJoin('academic_sessions', 'academic_sessions.uuid', '=', 'assessments.academic_session_id')
                                     ->leftJoin('school_terms', 'school_terms.uuid', '=', 'assessments.school_term_id')
                                     ->select('assessments.uuid', 'assessments.assessment_code', 'assessments.title', 'assessments.is_published', 'assessments.is_standalone','assessments.start_date', 'assessments.end_date','assessments.description', 'assessments.assessment_duration', 'assessment_types.type', 'academic_sessions.session', 'school_terms.term');
        
        return new static( [...$this->item, 'query' => $assessments ]);
    }
}