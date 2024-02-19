<?php

namespace App\Console\Commands;

use App\Modules\SchoolManager\Models\StudentProfileModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MassAssignCourseToStudentCommand extends Command
{
    protected $signature = 'update:level';
    protected $description = 'Command description';

    public function handle()
    {
        DB::table('student_profiles')->where('class_id', "1")->update(['class_id' => '01HPRNPJ9EHM1VPMHQQPCKAXM3']);
    }
}
