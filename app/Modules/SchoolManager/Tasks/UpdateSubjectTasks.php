<?php

namespace App\Modules\SchoolManager\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\SchoolManager\Models\SubjectModel;

class UpdateSubjectTasks extends BaseTasks{

    public function updateSubject()
    {
        $subject = SubjectModel::find($this->item['subjectId']);

        $subject->update(['subject_name' => $this->item['subjectName'], 'subject_code' => $this->item['subjectCode'] ?? null ]);

        return new static( $this->item );
    }
    
}