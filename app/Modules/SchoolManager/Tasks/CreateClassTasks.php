<?php

namespace App\Modules\SchoolManager\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\SchoolManager\Models\ClassModel;
use Illuminate\Support\Str;

class CreateClassTasks extends BaseTasks {

    public function generateClassCode()
    {
        $code = str_pad( strval( ClassModel::count() + 1 ), 3 , "000" , STR_PAD_LEFT );
        $class_code = str_replace( " ", "_", strtoupper( $this->item['className'] )."_".$code );

        return new static([ ...$this->item, 'class_code' => $class_code ]);
    }

    public function addClassToDatabase()
    {
        ClassModel::create([
            'uuid'       => Str::ulid(),
            'class_name' => $this->item['className'],
            'class_code' => $this->item['class_code']
        ]);

        return new static( $this->item );
    }   
}