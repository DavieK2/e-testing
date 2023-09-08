<?php

namespace App\Modules\SchoolManager\Tasks;

use App\Contracts\BaseTasks;

class GetTeacherAssignedSubjectTasks extends BaseTasks{

    public function getSubjects()
    {
        $subjects = $this->item['teacher']->subjects();

        return new static( [ 'query' => $subjects ] );
    }
    
}