<?php

namespace App\Modules\CBT\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\CBT\Models\AssessmentModel;
use App\Modules\CBT\Requests\GetStudentResultRequest;
use App\Modules\CBT\Requests\GetTermlyAssessmentResultRequest;
use App\Modules\CBT\Resources\AssessmentSubjectsCollection;
use App\Modules\CBT\Resources\GetTermlyAssessmentResultListCollection;
use App\Modules\CBT\Tasks\GetAssessmentSubjectsTasks;
use App\Modules\Excel\Export;
use App\Modules\SchoolManager\Models\StudentProfileModel;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AssessmentResultController extends Controller
{
    public function subjects(AssessmentModel $assessment)
    {
        $assessmentSubjects = (new GetAssessmentSubjectsTasks())->start(['assessment' => $assessment])->getSubjects()->all()->get();

        return new AssessmentSubjectsCollection($assessmentSubjects);
    }

    public function getTermlyAssessmentResults(GetTermlyAssessmentResultRequest $request)
    {
        $data = $request->validated();

        $assessment = AssessmentModel::firstWhere('uuid', $data['assessmentId']);

        $results =  DB::table('assessment_results')
                        ->leftJoin('student_profiles', 'student_profiles.id', '=', 'assessment_results.student_profile_id')
                        ->join('classes', 'student_profiles.class_id', '=', 'classes.id')
                        ->join('subjects', 'assessment_results.subject_id', '=', 'subjects.id')
                        ->where( fn($query) => $query->where('assessment_results.assessment_id', $assessment->id )->where('assessment_results.subject_id', $data['subjectId'])->where('student_profiles.class_id', $data['classId']) )
                        ->select('student_profiles.first_name', 'student_profiles.surname', 'student_profiles.reg_no', 'student_profiles.id', 'classes.class_name', 'subjects.subject_name', 'subjects.subject_code', 'assessment_results.total_score', 'assessment_results.grade')
                        ->get();

        if( $data['export'] ){

            $results = $results->map(function($result, $key){
                
                return [
                    'S/N' => $key + 1,
                    'studentName' => strtoupper("$result->first_name $result->surname"),
                    'studentCode' => strtoupper($result->reg_no),
                    'studentLevel' => strtoupper($result->class_name),
                    'course' => strtoupper("$result->subject_name ($result->subject_code)"),
                    'score' => $result->total_score,
                    'grade' => $result->grade,
                ];
            });

            return Excel::download( new Export($results), "$assessment->title.xlsx" );
        }

        return new GetTermlyAssessmentResultListCollection($results);   

    }

    public function getStudentResults(GetStudentResultRequest $request)
    {
        $data = $request->validated();

        $student = StudentProfileModel::find($data['studentId']);
        $assessmentId = AssessmentModel::firstWhere('uuid',$data['assessmentId'])->id;

        $results = DB::table('assessment_results')
                        ->join('student_profiles', 'student_profiles.id', '=', 'assessment_results.student_profile_id')
                        ->join('classes', 'student_profiles.class_id', '=', 'classes.id')
                        ->join('subjects', 'assessment_results.subject_id', '=', 'subjects.id')
                        ->where(fn($query) => $query ->where('assessment_id', $assessmentId)->where('student_profile_id', $data['studentId']))
                        ->select('subjects.subject_name as subjectName', 'subjects.subject_code as subjectCode', 'assessment_results.total_score as score', 'assessment_results.grade')
                        ->get()
                        ->toArray();

        return response()->json([
            'studentName'       => "$student->first_name $student->surname",
            'studentClass'      => $student->class->class_name,
            'studentPhoto'      => $student->profile_pic,
            'studentId'         => $student->student_code,
            'studentResults'    => $results,
        ]);
    }
}
