<?php

namespace App\Modules\CBT\Tasks;

use App\Contracts\BaseTasks;

class GetTeacherClassesTask extends BaseTasks{

    public function getClasses()
    {
        $classes = $this->item['teacher']->classes()->select('class_code', 'class_name');
        
        return new static( [ 'query' => $classes ] );
    }
    
}