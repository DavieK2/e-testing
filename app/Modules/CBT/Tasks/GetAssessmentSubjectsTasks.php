<?php

namespace App\Modules\CBT\Tasks;

use App\Contracts\BaseTasks;

class GetAssessmentSubjectsTasks extends BaseTasks{

    public function getSubjects()
    {
        $subjects = $this->item['assessment']->subjects();

        if( isset($this->item['classId']) ){

            $subjects->where('class_id', $this->item['classId'] );
        }

        return new static( [ 'query' =>  $subjects ]);
    }
    
}