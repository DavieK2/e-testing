<?php

namespace App\Modules\SchoolManager\Tasks;

use App\Contracts\BaseTasks;

class GetTeacherAssignedClassTasks extends BaseTasks{

    public function getClasses()
    {
        $classes = $this->item['teacher']->classes();

        return new static( [ 'query' => $classes ] );
    }
    
}