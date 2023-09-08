<?php

namespace App\Modules\CBT\Tasks;

use App\Contracts\BaseTasks;

class GetTeacherClassSubjectsTasks extends BaseTasks {

    public function getSubjects()
    {
        $classId = $this->item['class']->id;

        $subjects = $this->item['teacher']->subjects()
                                            ->join('class_subjects', 'subjects.id', '=', 'class_subjects.subject_id' )
                                            ->where('class_subjects.class_id', $classId)
                                            ->select('subjects.*');

        return new static( [ ...$this->item, 'query' => $subjects ]);
    }
    
}