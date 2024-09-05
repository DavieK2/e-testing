<?php

namespace App\Modules\CBT\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\CBT\Models\AssessmentTypeModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

class AssessmentTypeTasks extends BaseTasks{

    protected AssessmentTypeModel|null $assessment_type = null;

    public function getTypes() : static
    {
        return new static( [...$this->item, 'query' => AssessmentTypeModel::query()->select('uuid as id', 'type', 'max_score') ] );
    }

    public function createAssessmentType() : static
    {
        AssessmentTypeModel::create([
            'uuid'      => Str::ulid(),
            'type'      => $this->item['assessmentType'],
            'max_score' => $this->item['maxScore'],
        ]);

        return new static( $this->item );
    }

    public function updateAssessmentType() : static
    {
        $this->assessment_type->update([ 
            'type' => $this->item['assessmentType'], 
            'max_score' => $this->item['maxScore'] 
        ]);

        return new static( $this->item );
    }

    public function assessmentType( AssessmentTypeModel $assessment_type ) : static
    {
        if( ! $assessment_type->exists ) throw new ModelNotFoundException();

        $this->assessment_type = $assessment_type;

        return $this;
    }
    
}