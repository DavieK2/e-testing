<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Models\TermModel;
use App\Modules\SchoolManager\Tasks\TermTasks;

class UpdateTermFeature extends FeatureContract {

    public function __construct(protected TermModel $term){
        $this->tasks = new TermTasks();
    }
    
    public function handle(BaseTasks|TermTasks $task, array $args = [])
    {
       try {
            
            return $task->withParameters($args)
                        ->term($this->term)
                        ->updateTerm()
                        ->empty()
                        ->formatResponse( options:[
                            'status' => 200, 
                            'message' => 'Term updated successfuly'
                        ]);

       } catch (\Throwable $th) {
        
            throw $th;
       }
    }
}