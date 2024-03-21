<?php

namespace App\Modules\SchoolManager\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\SchoolManager\Models\StudentProfileModel;
use App\Modules\SchoolManager\Services\UploadCSVService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class CreateStudentTasks extends BaseTasks{

    public function createStudent()
    {
        if( $this->item['studentCode'] ){

            $student_code = $this->item['studentCode'];

        }else{
            
            $count = StudentProfileModel::count() + 1;
            $student_code = 'JEPH-'.str_pad(strval($count), 4, '0', STR_PAD_LEFT).'-'.Str::random(4);
        }
      

        $student = StudentProfileModel::create([
            'uuid'          =>  Str::ulid(),
            'first_name'     =>  $this->item['firstName'],
            'surname'       =>  $this->item['surname'],
            'class_id'      =>  $this->item['classId'],
            'profile_pic'    =>  $this->item['profilePic'],
            'student_code'  =>  strtoupper($student_code)
        ]);

        return new static( [ ...$this->item, 'student' => $student ]);
    }

    public function uploadCSV()
    {
        $upload = ( new UploadCSVService() )->saveFileToLocalDiskAndReturnFirstRowWithPath( 'imports/students', $this->item['file'] );

        $key = Str::random(6);

        Cache::put( $key, $upload['key'], now()->addMinutes(60) );

        return new static( ['key' => $key, 'headings' => $upload['headings'] ]);

    }

    
    
}