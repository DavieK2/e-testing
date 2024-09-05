<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Models\SubjectModel;
use App\Modules\SchoolManager\Tasks\SubjectTasks;

class UpdateSubjectFeature extends FeatureContract {

    public function __construct(protected SubjectModel $subject){
        $this->tasks = new SubjectTasks();
    }
    
    public function handle(BaseTasks|SubjectTasks $task, array $args = [])
    {
       try {
            
            return $task->withParameters($args)
                        ->subject($this->subject)
                        ->updateSubject()
                        ->empty()
                        ->formatResponse( 
                            options: [ 
                                'message' => 'Subject update successfully', 
                                'status' => 200 
                        ]);

       } catch (\Throwable $th) {
        
            throw $th;
       }
    }
}