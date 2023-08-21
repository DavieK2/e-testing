<?php

namespace App\Modules\CBT\Tasks;

use App\Contracts\BaseTasks;

class UpdateAssessmentTask extends BaseTasks {

    public function updateAssessment()
    {
        $task =  (new CreateAssessmentTasks())->start($this->item);

        if( isset($this->item['publish']) ){

            $task->getAssessment()->update([ 'is_published' => $this->item['publish'] ]);

        }else{

            $task->getAssessment()->update($task->getAssessmentData());
        }
       
        return new static( $this->item );

    }
    
}