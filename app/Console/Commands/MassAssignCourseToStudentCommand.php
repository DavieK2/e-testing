<?php

namespace App\Console\Commands;

use App\Modules\SchoolManager\Models\StudentProfileModel;
use Illuminate\Console\Command;

class MassAssignCourseToStudentCommand extends Command
{
    protected $signature = 'app:assign-course';
    protected $description = 'Command description';

    public function handle()
    {
        StudentProfileModel::where('class_id', 1)->get()->each(function($student){
            $student->assignSubject([14,15,16,17,18,19,20]);
        });
    }
}
