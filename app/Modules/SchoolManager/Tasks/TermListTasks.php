<?php

namespace App\Modules\SchoolManager\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\SchoolManager\Models\TermModel;

class TermListTasks extends BaseTasks{

    public function getTerms()
    {
        $terms = TermModel::query()->select('id', 'term');

        return new static( [ ...$this->item, 'query' => $terms ]);
    }
    
}