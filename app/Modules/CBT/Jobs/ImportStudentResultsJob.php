<?php

namespace App\Modules\CBT\Jobs;

use App\Modules\CBT\Models\AssessmentModel;
use App\Modules\CBT\Models\ExamResultsModel;
use App\Modules\SchoolManager\Models\StudentProfileModel;
use Illuminate\Foundation\Bus\Dispatchable;
use Spatie\SimpleExcel\SimpleExcelReader;
use Illuminate\Support\Str;

class ImportStudentResultsJob
{
    use Dispatchable;

   
    public function __construct()
    {
        //
    }

    public function handle()
    {
        $assessment = AssessmentModel::create([
            'uuid'  => Str::ulid(),
            'title' => 'NURSING CA OCTOBER 2022',
            'description' => 'Please read each question carefully before answering',
            'is_standalone' => 0,
            'assessment_type_id' => 6,
            'academic_session_id' => 3,
            'school_term_id' => 2
        ]);

        $assessment->addClassesToAssessment([1]);

        $paths = [
            14 => 'ANATOMY_PHYSIOLOGY.xlsx',
            16 => 'ETHICS_JURISPRUDENCE.xlsx',
            18 => 'MED_SURG_CA.xlsx',
            17 => 'PHAMACOLOGY_CA.xlsx',
            19 => 'PHC_CA.xlsx',
            15 => 'PHYCHOLOGY_CA.xlsx',
            20 => 'FON.xlsx'
        ];

        foreach ($paths as $key => $value) {
            $assessment->subjects()->syncWithoutDetaching([ $key => ['uuid' => Str::ulid(), 'class_id' => 1, 'assessment_duration' => 0, 'start_date' => now()->toDateTimeString(), 'end_date' => now()->toDateTimeString() ] ]);
        }

        foreach( $paths as $key => $path){

            SimpleExcelReader::create( base_path($path) )->getRows()->each(function($row) use($assessment, $key){

                $studentCode = $row['EXAM NO'];
                $studentCode = str_pad($studentCode, 3, '0', STR_PAD_LEFT); 
                $studentCode = 'SOBNCAL/22/'.$studentCode;

                $studentId = StudentProfileModel::firstWhere('student_code', $studentCode)?->id;

                if( ! $studentId ) return;

                $score = $row['TOTAL SCORE 30%'] ?? $row['SCORES'];
                
                ExamResultsModel::updateOrCreate([
                    'student_profile_id' => $studentId,
                    'assessment_id' => $assessment->id,
                    'subject_id' => $key,
                ],
                [
                    'uuid' => Str::ulid(),
                    'student_profile_id' => $studentId,
                    'assessment_id' => $assessment->id,
                    'subject_id' => $key,
                    'total_score' => floatval($score)
                ]);
            });
        }
        
    }
}
