<?php

namespace App\Modules\CBT\Tasks;

use App\Contracts\BaseTasks;

class GetPublishedAssessmentTask extends BaseTasks{

    public function getAssessments()
    {
        $assessment = (new AssessmentListTasks())->getAssessments()->item['query']->where(fn($query) => $query->where('assessments.is_published', true)->where('is_standalone', false))->select('assessments.uuid as assessmentId', 'assessments.title');

        return new static( [ ...$this->item, 'query' => $assessment ]);
    }
    
}