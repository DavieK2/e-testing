<?php

namespace App\Modules\CBT\Tasks;

use App\Contracts\BaseTasks;

class UnAssignQuestionFromAssessmentTask extends BaseTasks{

    public function unAssignQuestionFromAssessment()
    {
        $this->item['assessment']->unAssignQuestion( $this->item['questionId'] );

        return new static( $this->item );
    }
    
}