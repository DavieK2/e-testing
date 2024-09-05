<?php

namespace App\Modules\SchoolManager\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\SchoolManager\Models\SubjectModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

class SubjectTasks extends BaseTasks{

    protected SubjectModel|null $subject = null;

    public function generateSubjectCode()
    {
        if( $this->item['subjectCode']){
            $subject_code = $this->item['subjectCode'];
        }
        else{
            $code = str_pad( strval( SubjectModel::count() + 1 ), 3 , "000" , STR_PAD_LEFT );
            $subject_code = str_replace( " ", "_", strtoupper( $this->item['subjectName'] )."_".$code );
        }
       

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
    
    public function getSubjects()
    {
        return new static( [ ...$this->item, 'query' => SubjectModel::query()->select('uuid as subjectId', 'subject_name as subjectName', 'subject_code as subjectCode') ]);
    }

    public function subject( SubjectModel $subject)
    {
        if( ! $subject->exists ) throw new ModelNotFoundException();

        $this->subject = $subject;

        return $this;
    }


    public function updateSubject()
    {
        $this->subject->update(['subject_name' => $this->item['subjectName'], 'subject_code' => $this->item['subjectCode'] ?? null ]);

        return new static( $this->item );
    }
    
}