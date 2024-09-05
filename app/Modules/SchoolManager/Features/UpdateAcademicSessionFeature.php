<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Models\AcademicSessionModel;
use App\Modules\SchoolManager\Tasks\AcademicSessionTasks;

class UpdateAcademicSessionFeature extends FeatureContract {

    public function __construct(protected AcademicSessionModel $academic_session){
        $this->tasks = new AcademicSessionTasks();
    }
    
    public function handle(BaseTasks|AcademicSessionTasks $task, array $args = [])
    {
       try {

            return $task->withParameters($args)
                        ->academicSession( $this->academic_session )
                        ->updateAcademicSession()
                        ->empty()
                        ->formatResponse( options:[
                            'status' => 200, 
                            'message' => 'Academic updated successfuly'
                        ] );

       } catch (\Throwable $th) {
        
            throw $th;
       }
    }
}