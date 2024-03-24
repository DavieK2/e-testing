<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Tasks\GetStudentDataTasks;

class DownloadStudentDataFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new GetStudentDataTasks();
    }
    
    public function handle( BaseTasks $task, array $args = [] )
    {
        $builder = $task->start($args)->downloadStudentData();

        return $task::formatResponse( $builder->only(['']) );
    }
}