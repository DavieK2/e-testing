<?php

namespace App\Modules\SchoolManager\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\SchoolManager\Models\ClassModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClassTasks extends BaseTasks{

    protected ClassModel|null $class = null;

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
    
    public function getClasses()
    {
        return new static( [ ...$this->item, 'query' => ClassModel::query()->select('uuid as id', 'class_code', 'class_name') ]);
    }

    public function class( ClassModel $class )
    {
        if( ! $class->exists ) throw new ModelNotFoundException();

        $this->class =  $class;

        return $this;
    }

    // public function getClassSubjects()
    // {
    
    //     $classes = $this->item['classes'];

    //     $subjects = DB::table('class_subjects')
    //                     ->join('subjects', 'subjects.uuid', '=', 'subject_id')
    //                     ->where( fn($query) => $query->whereIn('class_id', $classes))
    //                     ->select('subjects.uuid as subjectId', 'subjects.subject_name as subjectName', 'class_subjects.class_id as classId')
    //                     ->get()
    //                     ->groupBy('classId')
    //                     ->map( fn($subject) => $subject->groupBy('subjectId')->mapWithKeys(fn($subject, $key) => [ $key => $subject[0] ])->toArray() )
    //                     ->toArray();

        
    //     return new static($subjects);
    // }

    public function getClassSubjects()
    {
    
       $subjects = DB::table('class_subjects')
                      ->join('subjects', 'subjects.uuid', '=', 'subject_id')
                      ->where('class_id', $this->class->uuid)
                      ->select('subjects.uuid as subjectId', 'subjects.subject_name as subjectName', 'class_subjects.class_id as classId')
                      ->get();

        return new static( $subjects );
    }

    public function updateClass()
    {

        $this->class->update( ['class_name' => $this->item['className']] );

        return new static( $this->item );
    }

    public function assignSubjects()
    {
        $this->class->assignSubjects( $this->item['subjects'] );

        return new static( $this->item );
    }
    
}