<?php

namespace App\Modules\SchoolManager\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\SchoolManager\Models\TermModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

class TermTasks extends BaseTasks{

    protected TermModel|null $term = null;

    public function getTerms()
    {
        $terms = TermModel::query()->select('uuid as id', 'term');

        return new static( [ ...$this->item, 'query' => $terms ]);
    }

    public function updateTerm()
    {
        $this->term->update( ['term' => $this->item['term']] );

        return new static( $this->item );
    }

    public function term(TermModel $term)
    {
        if( ! $term->exists ) throw new ModelNotFoundException();
        
        $this->term = $term;

        return $this;
    }

    public function createTerm()
    {
        TermModel::create([
            'uuid'  =>  Str::ulid(),
            'term'  => $this->item['term']
        ]);

        return new static( $this->item );
    }
    
}