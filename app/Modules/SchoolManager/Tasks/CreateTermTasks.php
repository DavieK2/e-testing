<?php

namespace App\Modules\SchoolManager\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\SchoolManager\Models\TermModel;
use Illuminate\Support\Str;

class CreateTermTasks extends BaseTasks{

    public function storeToDatabase()
    {

        // dd( $this->item );

        TermModel::create([
            'uuid'  =>  Str::ulid(),
            'term'  => $this->item['term']
        ]);

        return new static( $this->item );
    }
    
}