<?php

namespace App\Modules\SchoolManager\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\SchoolManager\Models\SubjectModel;

class SubjectListTasks extends BaseTasks{

    public function getSubjects()
    {
        return new static( [ ...$this->item, 'query' => SubjectModel::query()->select('id as subjectId', 'subject_name as subjectName') ]);
    }
    
}