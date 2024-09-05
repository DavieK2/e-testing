<?php

namespace App\Console\Commands;

use App\Modules\SchoolManager\Models\StudentProfileModel;
use Illuminate\Console\Command;
use Intervention\Image\Facades\Image;

class ConvertStudentProfileImageFromDataURLToJPG extends Command
{
    protected $signature = 'app:convert-student-profile-image';
    protected $description = 'Command description';

    public function handle()
    {
       set_time_limit(0);

       StudentProfileModel::cursor()->each( function($student)  {

        if( ( substr( ($student->profile_pic ?? ''), 0, 5 ) === 'data:' ) ){

            $image = Image::make($student->profile_pic);

            $image->resize(800, null, fn ($constraint) => $constraint->aspectRatio() );

            $student_code = $student->student_code;

            $student_code = str_replace('/', '-', $student_code);

            $pic_name = "profile_pics/".$student_code.".jpg";

            $image->save(public_path($pic_name));

            $student->update(['profile_pic' => $pic_name ]);
        }

       } );
    }
}
