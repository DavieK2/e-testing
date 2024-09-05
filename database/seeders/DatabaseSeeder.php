<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Modules\CBT\Models\AssessmentModel;
use App\Modules\CBT\Models\AssessmentTypeModel;
use App\Modules\SchoolManager\Models\AcademicSessionModel;
use App\Modules\SchoolManager\Models\ClassModel;
use App\Modules\SchoolManager\Models\SubjectModel;
use App\Modules\SchoolManager\Models\TermModel;
use App\Modules\UserManager\Models\RoleModel;
use App\Modules\UserManager\Models\UserModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Cache::flush();

        $role1 = RoleModel::create([
            'role_name' => 'teacher'
        ]);

        $role3 = RoleModel::create([
            'role_name' => 'admin'
        ]);

        $role4 = RoleModel::create([
            'role_name' => 'checkin'
        ]);

        $role5 = RoleModel::create([
            'role_name' => 'capture'
        ]);

        UserModel::create([
            'uuid'     => Str::ulid(),
            'fullname' => 'Admin',
            'email' => 'admin@cbt.com',
            'password' => Hash::make('CBTadmin1234!'),
            'phone_no' => '2345678900000',
            'role_id' => $role3->uuid
        ]);

        UserModel::create([
            'fullname'  => 'Test Teacher',
            'email'     => 'teacher@example.com',
            'password'  => Hash::make('password'),
            'phone_no'  => '2345678900100',
            'role_id'   => $role1->uuid
        ]);

        $academic_session_1 = AcademicSessionModel::create(['session' => '2022/2023', 'uuid' => Str::ulid()]);
        $academic_session_2 = AcademicSessionModel::create(['session' => '2023/2024', 'uuid' => Str::ulid()]);

        $semester_1 = TermModel::create(['term' => 'First Semester']);
        $semester_2 = TermModel::create(['term' => 'Second Semester']);

        $exam = AssessmentTypeModel::create(['type' => 'Exam', 'max_score' => 100]);

        // UserModel::create([
        //     'fullname'  => 'Check-In User 5',
        //     'email'     => 'checkin5@gss.com',
        //     'password'  => Hash::make('ADMINchecker123356#'),
        //     'phone_no'  => '2344455654321',
        //     'role_id'   => $role4->uuid
        // ]);

        // UserModel::create([
        //     'fullname'  => 'Check-In User 1',
        //     'email'     => 'checkin1@gss.com',
        //     'password'  => Hash::make('ADMINchecker1234777#'),
        //     'phone_no'  => '234999888754321',
        //     'role_id'   => $role4->uuid
        // ]);

        // UserModel::create([
        //     'fullname'  => 'Check-In User 2',
        //     'email'     => 'checkin2@gss.com',
        //     'password'  => Hash::make('ADMINchecker1234333#'),
        //     'phone_no'  => '23499887654321',
        //     'role_id'   => $role4->uuid
        // ]);

        // UserModel::create([
        //     'fullname'  => 'Check-In User 3',
        //     'email'     => 'checkin3@gss.com',
        //     'password'  => Hash::make('ADMINchecker1234665#'),
        //     'phone_no'  => '23490324674321',
        //     'role_id'   => $role4->uuid
        // ]);

        // UserModel::create([
        //     'fullname'  => 'Check-In User 4',
        //     'email'     => 'checkin4@gss.com',
        //     'password'  => Hash::make('ADMINchecker1234443#'),
        //     'phone_no'  => '234908763331',
        //     'role_id'   => $role4->uuid
        // ]);

        // UserModel::create([
        //     'fullname'  => 'Check-In User 6',
        //     'email'     => 'checkin6@gss.com',
        //     'password'  => Hash::make('ADMINchecker1234123#'),
        //     'phone_no'  => '200087654321',
        //     'role_id'   => $role4->uuid
        // ]);


        // UserModel::create([
        //     'fullname'  => 'Check-In User 7',
        //     'email'     => 'checkin7@gss.com',
        //     'password'  => Hash::make('ADMINchecker1234ee3#'),
        //     'phone_no'  => '234666654321',
        //     'role_id'   => $role4->uuid
        // ]);


        // UserModel::create([
        //     'fullname'  => 'Capture Admin',
        //     'email'     => 'capture@gss.com',
        //     'password'  => Hash::make('ADMINelcap1234#'),
        //     'phone_no'  => '23490879994621',
        //     'role_id'   => $role5->uuid
        // ]);


        // Schema::disableForeignKeyConstraints();

        // DB::unprepared( file_get_contents( base_path('faculties.sql')) );
        // DB::unprepared( file_get_contents( base_path('classes.sql')) );
        // DB::unprepared( file_get_contents(base_path('subjects.sql')) );
        // DB::unprepared( file_get_contents(base_path('departments.sql')) );
        
        // DB::unprepared( file_get_contents(base_path('student_profiles_latest.sql')) );
        // DB::unprepared( file_get_contents(base_path('student_subjects_latest.sql')) );


        


        // $first_semester_courses = ['GSS101','GSS131','GSS121','GSS111','GSS211','GST111','GSS123'];
        // $second_semester_courses = ['GSS102','GSS132','GSS122','GSS112','GST112'];

        // $first_semester_courses = collect( $first_semester_courses )->map( function($course) use($semester_1) {

        //     $course = SubjectModel::firstWhere('subject_code', $course);

        //     return [
        //         'uuid'          => Str::ulid(),
        //         'term_id'       => $semester_1->uuid,
        //         'subject_id'    => $course->uuid,
        //     ];
        // })->toArray();

        // $second_semester_courses = collect( $second_semester_courses )->map( function($course) use($semester_2) {

        //     $course = SubjectModel::firstWhere('subject_code', $course);

        //     return [
        //         'uuid'          => Str::ulid(),
        //         'term_id'       => $semester_2->uuid,
        //         'subject_id'    => $course->uuid,
        //     ];
        // })->toArray();

        // DB::table('term_subjects')->insert([ ...$first_semester_courses, ...$second_semester_courses ]);

        // $assessment_type = AssessmentTypeModel::create(['type' => 'Exam', 'max_score' => 90]);

        // ClassModel::get()->map( function( $class ){

        //     $subjects = SubjectModel::get()->map( function( $subject ) use( $class ) {
    
        //         return [
        //             'uuid'          => Str::ulid(),
        //             'subject_id'    => $subject->uuid,
        //             'class_id'      => $class->uuid
        //         ];
        //     });
    
        //     return $subjects;
    
        // })->each( fn( $class ) => DB::table('class_subjects')->insert( $class->toArray() ) );


        // $assessment = AssessmentModel::create([
        //     'uuid'                  => Str::ulid(),
        //     'title'                 => 'GSS FIRST SEMESTER EXAMS',
        //     'description'           => 'Please read all questions carefully before answering. This exam has two section. You are to finish both sections before submitting the exam.',
        //     'is_standalone'         => false,
        //     'is_published'          => false,
        //     'assessment_type_id'    => $assessment_type->uuid,
        //     'academic_session_id'   => $academic_session_2->uuid,
        //     'school_term_id'        => $semester_1->uuid,
        //     'assessment_code'       => Str::random(6)   
        // ]);

        // ClassModel::get()->map( function( $class )use( $assessment ){

        //     DB::table('assessment_classes')->insert( ['uuid' => Str::ulid(), 'assessment_id' => $assessment->uuid, 'class_id' => $class->uuid ] );

        // });

        // $class = ClassModel::get()->map( function( $class )use( $assessment ){


        //     return SubjectModel::get()->map( function( $sub ) use( $assessment, $class ){
                
        //         return [
        //             'uuid'                  => Str::ulid() ,
        //             'assessment_id'         => $assessment->uuid, 
        //             'subject_id'            => $sub->uuid, 
        //             'is_published'          => false, 
        //             'class_id'              => $class->uuid,
        //             'assessment_duration'   => ( 30 * 60 ),
        //             'start_date'            => now()->startOfDay()->toDateTimeString(),
        //             'end_date'              => now()->addDay()->startOfDay()->toDateTimeString(),
        //             'is_published'          => true
        //         ];
        //     });
        // });

        // $class->each( function($cls) {
            
        //     DB::table('assessment_subjects')->insert( $cls->toArray() );

        // } );
    }
}
