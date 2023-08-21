<?php

namespace App\Modules\UserManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\UserManager\Tasks\CreateUserTask;

class CreateUserFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new CreateUserTask();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
       try {
            
       } catch (\Throwable $th) {
            throw $th;
       }
    }
}