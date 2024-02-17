<?php

namespace App\Modules\SchoolManager\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\SchoolManager\Models\AcademicSessionModel;

class UpdateAcademicSessionTasks extends BaseTasks{

    public function updateAcademicSession()
    {        
        $academic_session = AcademicSessionModel::find($this->item['academicSessionId']);

        $academic_session->update(['session' => $this->item['session']]);

        return new static( $this->item );
    }
    
}