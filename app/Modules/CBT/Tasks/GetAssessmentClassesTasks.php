<?php

namespace App\Modules\CBT\Tasks;

use App\Contracts\BaseTasks;

class GetAssessmentClassesTasks extends BaseTasks{

    public function getAssessmentClasses()
    {
        $classes = $this->item->classes()->select('classes.id', 'classes.class_code', 'classes.class_name');

        return new static( ['query' => $classes ]);
    }
    
}