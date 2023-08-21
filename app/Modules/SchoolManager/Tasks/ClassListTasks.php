<?php

namespace App\Modules\SchoolManager\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\SchoolManager\Models\ClassModel;

class ClassListTasks extends BaseTasks{

    public function getClasses()
    {
        return new static( [ ...$this->item, 'query' => ClassModel::query()->select('id', 'class_code', 'class_name') ]);
    }

    public function getClassSubjects()
    {
        return new static(['query' => $this->item->subjects()->select('subjects.id as subjectId', 'subjects.subject_name as subjectName', 'class_subjects.class_id as classId') ]);
    }
    

}