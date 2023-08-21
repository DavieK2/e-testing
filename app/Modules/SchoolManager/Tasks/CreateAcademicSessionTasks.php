<?php

namespace App\Modules\SchoolManager\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\SchoolManager\Models\AcademicSessionModel;

class CreateAcademicSessionTasks extends BaseTasks{

    public function storeToDatabase()
    {
        AcademicSessionModel::create(['session' => $this->item['session']]);

        return new static( $this->item );
    }
    
}