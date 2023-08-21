<?php

namespace App\Modules\CBT\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\CBT\Models\AssessmentTypeModel;

class AssessmentTypeListTasks extends BaseTasks{

    public function getTypes()
    {
        return new static( [...$this->item, 'query' => AssessmentTypeModel::query()->select('id', 'type', 'max_score') ] );
    }
    
}