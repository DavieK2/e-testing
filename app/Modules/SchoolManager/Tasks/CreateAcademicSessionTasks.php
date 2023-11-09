<?php

namespace App\Modules\SchoolManager\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\SchoolManager\Models\AcademicSessionModel;
use Illuminate\Support\Str;

class CreateAcademicSessionTasks extends BaseTasks{

    public function storeToDatabase()
    {
        AcademicSessionModel::create([
            'uuid'    => Str::ulid(),
            'session' => $this->item['session']
        ]);

        return new static( $this->item );
    }
    
}