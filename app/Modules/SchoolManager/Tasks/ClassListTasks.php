<?php

namespace App\Modules\SchoolManager\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\SchoolManager\Models\ClassModel;
use Illuminate\Support\Facades\DB;

class ClassListTasks extends BaseTasks{

    public function getClasses()
    {
        return new static( [ ...$this->item, 'query' => ClassModel::query()->select('uuid as id', 'class_code', 'class_name') ]);
    }

    public function getClassSubjects()
    {
    
        $classes = $this->item['classes'];

        $subjects = DB::table('class_subjects')
                        ->join('subjects', 'subjects.uuid', '=', 'subject_id')
                        ->where( fn($query) => $query->whereIn('class_id', $classes))
                        ->select('subjects.uuid as subjectId', 'subjects.subject_name as subjectName', 'class_subjects.class_id as classId')
                        ->get()
                        ->groupBy('classId');

        
        return new static($subjects);
    }
    

}