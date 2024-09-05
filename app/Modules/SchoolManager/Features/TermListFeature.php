<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Tasks\TermTasks;

class TermListFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new TermTasks();
    }
    
    public function handle(BaseTasks|TermTasks $task, array $args = [])
    {
       try {

            return $task->getTerms()
                        ->all()
                        ->formatResponse();
            
       } catch (\Throwable $th) {
            throw $th;
       }
    }
}