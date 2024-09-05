<?php

namespace App\Modules\SchoolManager\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\SchoolManager\Models\AcademicSessionModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

class AcademicSessionTasks extends BaseTasks{

    protected AcademicSessionModel|null $academic_session = null;

    public function getSessions()
    {
        return new static( [ ...$this->item, 'query' => AcademicSessionModel::query()->select('uuid as id', 'session') ]);
    }
    
    public function createAcademicSession()
    {
        AcademicSessionModel::create([
            'uuid'    => Str::ulid(),
            'session' => $this->item['session']
        ]);

        return new static( $this->item );
    }

    public function updateAcademicSession()
    {        
        $this->academic_session->update(['session' => $this->item['session']]);

        return new static( $this->item );
    }

    public function academicSession(AcademicSessionModel $academic_session)
    {
        if( ! $academic_session->exists ) throw new ModelNotFoundException();

        $this->academic_session = $academic_session;

        return $this;
    }

}