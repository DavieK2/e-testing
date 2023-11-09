<?php

namespace App\Modules\CBT\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\CBT\Models\AssessmentTypeModel;
use Illuminate\Support\Str;

class CreateAssessmentTypeTasks extends BaseTasks{

    public function addAssessmentTypeToDatabase()
    {
        AssessmentTypeModel::create([
            'uuid'      => Str::ulid(),
            'type'      => $this->item['assessmentType'],
            'max_score' => $this->item['maxScore'],
        ]);

        return new static( $this->item );
    }
    
}