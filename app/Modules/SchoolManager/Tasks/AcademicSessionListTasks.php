<?php

namespace App\Modules\SchoolManager\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\SchoolManager\Models\AcademicSessionModel;

class AcademicSessionListTasks extends BaseTasks{

    public function getSessions()
    {
        return new static( [ ...$this->item, 'query' => AcademicSessionModel::query()->select('id', 'session') ]);
    }
    
}