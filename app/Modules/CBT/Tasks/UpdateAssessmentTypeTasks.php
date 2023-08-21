<?php

namespace App\Modules\CBT\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\CBT\Models\AssessmentTypeModel;

class UpdateAssessmentTypeTasks extends BaseTasks{

    public function updateAssessmentType()
    {
        $assessmentType = AssessmentTypeModel::find($this->item['assessmentTypeId']);

        $assessmentType->update([ 'type' => $this->item['assessmentType'], 'max_score' => $this->item['maxScore'] ]);

        return new static( $this->item );
    }
    
}