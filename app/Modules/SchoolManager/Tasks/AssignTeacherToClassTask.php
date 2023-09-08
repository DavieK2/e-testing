<?php

namespace App\Modules\SchoolManager\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\UserManager\Models\UserModel;

class AssignTeacherToClassTask extends BaseTasks{

    public function assignTeacherToClass()
    {
        $teacher = UserModel::find($this->item['teacherId']);

        $teacher->assignToClass( collect($this->item['classes'])->pluck('id')->toArray() );

        return new static( $this->item );
    }
    
}