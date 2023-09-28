<?php

namespace App\Console\Commands;

use App\Modules\CBT\Models\AssessmentModel;
use App\Modules\SchoolManager\Models\StudentProfileModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class GenerateResultPDFCommand extends Command
{
    protected $signature = 'app:generate-result-p-d-f-command';
    protected $description = 'Command description';

    public function handle()
    {
        $assessment = AssessmentModel::find(2);
 

    $student = StudentProfileModel::where('class_id', 3)->get()->each(function($student) use($assessment){
        $results = DB::table('assessment_results')
        ->join('student_profiles', 'student_profiles.id', '=', 'assessment_results.student_profile_id')
        ->join('classes', 'student_profiles.class_id', '=', 'classes.id')
        ->join('subjects', 'assessment_results.subject_id', '=', 'subjects.id')
        ->where(fn($query) => $query ->where('assessment_id', $assessment->id)->where('student_profile_id', $student->id))
        ->select('subjects.subject_name as subjectName', 'subjects.subject_code as subjectCode', 'assessment_results.total_score as score', 'assessment_results.grade', 'assessment_results.remarks as remarks')
        ->get()
        ->toArray();


        
        $studentName = "$student->first_name $student->surname";

        $pdf = Pdf::loadView('result',[
        'assessmentTitle'   => $assessment->title,
        'studentName'       => "$student->first_name $student->surname",
        'studentClass'      => $student->class->class_name,
        'studentPhoto'      => $student->profile_pic,
        'studentId'         => $student->student_code,
        'studentResults'    => $results,
        ]);

        $pdf->save("$studentName.pdf");
    });

    }
}