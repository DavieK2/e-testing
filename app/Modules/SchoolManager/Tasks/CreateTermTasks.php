<?php

namespace App\Modules\SchoolManager\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\SchoolManager\Models\TermModel;

class CreateTermTasks extends BaseTasks{

    public function storeToDatabase()
    {
        TermModel::create(['term' => $this->item['term']]);

        return new static( $this->item );
    }
    
}