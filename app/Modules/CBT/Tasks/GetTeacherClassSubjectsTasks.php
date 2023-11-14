<?php

namespace App\Modules\CBT\Tasks;

use App\Contracts\BaseTasks;

class GetTeacherClassSubjectsTasks extends BaseTasks {

    public function getSubjects()
    {
        $subjects = $this->item['teacher']->subjects();

        return new static( [ ...$this->item, 'query' => $subjects ]);
    }
    
}