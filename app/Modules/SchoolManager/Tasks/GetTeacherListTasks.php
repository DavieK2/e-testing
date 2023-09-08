<?php

namespace App\Modules\SchoolManager\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\UserManager\Models\UserModel;

class GetTeacherListTasks extends BaseTasks{

    public function getTeachers()
    {
        $teachers = UserModel::query()->teachers();

        return new static([ ...$this->item, 'query' => $teachers ]);
    }
    
}