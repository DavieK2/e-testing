<?php

namespace App\Modules\CBT\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\CBT\Models\QuestionModel;

class UnAssignQuestionFromAssessmentTask extends BaseTasks{

    public function unAssignQuestionFromAssessment()
    {
        $this->item['assessment']->unAssignQuestion( $this->item['questionId'], $this->item['classId'] ?? null, $this->item['subjectId'] ?? null );

        $assessmentId = QuestionModel::firstWhere('uuid', $this->item['questionId'])->assessment->uuid;

        return new static( [ ...$this->item, 'assessmentId' => $assessmentId ] );
    }
    
}