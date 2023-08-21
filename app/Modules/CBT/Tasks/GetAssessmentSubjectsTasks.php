<?php

namespace App\Modules\CBT\Tasks;

use App\Contracts\BaseTasks;

class GetAssessmentSubjectsTasks extends BaseTasks{

    public function getSubjects()
    {
        return new static( [ 'query' => $this->item->subjects() ]);
    }
    
}