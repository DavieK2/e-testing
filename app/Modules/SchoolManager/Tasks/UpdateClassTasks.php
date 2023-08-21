<?php

namespace App\Modules\SchoolManager\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\SchoolManager\Models\ClassModel;

class UpdateClassTasks extends BaseTasks{

    public function updateClass()
    {
        $class = ClassModel::find( $this->item['classId'] );

        $class->update( ['class_name' => $this->item['className']] );

        return new static( $this->item );
    }
    
}