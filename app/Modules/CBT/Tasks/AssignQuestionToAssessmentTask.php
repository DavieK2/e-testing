<?php

namespace App\Modules\CBT\Tasks;

use App\Contracts\BaseTasks;

class AssignQuestionToAssessmentTask extends BaseTasks{

    public function assignQuestionToAssessment()
    {
        dd( $this->item );
        $this->item['assessment']->assignQuestion( $this->item['questionId'], $this->item['subjectId'] ?? null, $this->item['classId'] ?? null );

        return new static( $this->item );
    }
    
}