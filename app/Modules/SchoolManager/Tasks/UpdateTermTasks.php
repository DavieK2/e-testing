<?php

namespace App\Modules\SchoolManager\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\SchoolManager\Models\TermModel;

class UpdateTermTasks extends BaseTasks{

    public function updateTerm()
    {
        $class = TermModel::find( $this->item['termId'] );

        $class->update( ['term' => $this->item['term']] );

        return new static( $this->item );
    }
    
}