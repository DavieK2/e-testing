<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Tasks\TermListTasks;

class TermListFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new TermListTasks();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
       try {

            $builder = $task->start($args)->getTerms()->all();

            return $task::formatResponse($builder);
            
       } catch (\Throwable $th) {
            throw $th;
       }
    }
}