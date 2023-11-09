<?php

namespace App\Modules\SchoolManager\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\SchoolManager\Models\SubjectModel;
use Illuminate\Support\Str;

class CreateSubjectsTasks extends BaseTasks{

    public function generateSubjectCode()
    {
        $code = str_pad( strval( SubjectModel::count() + 1 ), 3 , "000" , STR_PAD_LEFT );
        $subject_code = str_replace( " ", "_", strtoupper( $this->item['subjectName'] )."_".$code );

        return new static([ ...$this->item, 'subject_code' => $subject_code ]);
    }

    public function addSubjectToDatabase()
    {
        SubjectModel::create([
            'uuid'         => Str::ulid(),
            'subject_name' => $this->item['subjectName'],
            'subject_code' => $this->item['subject_code']
        ]);

        return new static( $this->item );
    }   
    
}