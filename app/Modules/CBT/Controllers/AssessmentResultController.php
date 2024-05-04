<?php

namespace App\Modules\CBT\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\CBT\Models\AssessmentModel;
use App\Modules\CBT\Models\SectionModel;
use App\Modules\CBT\Requests\GetStudentResultRequest;
use App\Modules\CBT\Requests\GetTermlyAssessmentResultRequest;
use App\Modules\CBT\Resources\AssessmentSubjectsCollection;
use App\Modules\CBT\Tasks\GetAssessmentSubjectsTasks;
use App\Modules\Excel\Export;
use App\Modules\SchoolManager\Models\ClassModel;
use App\Modules\SchoolManager\Models\StudentProfileModel;
use App\Modules\SchoolManager\Models\SubjectModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
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
        set_time_limit(0);


        $data = $request->validated();

        $assessment = AssessmentModel::firstWhere('uuid', $data['assessmentId'] );
        $subject = SubjectModel::find( $data['subjectId'] ); 
        $class = ClassModel::find( $data['classId'] );


        // dd( $subject );
        // $data = DB::table('assessment_sessions')
        //     ->join('student_profiles', 'student_profiles.uuid', '=', 'assessment_sessions.student_profile_id')
        //     ->where( function($query) use($assessment, $subject){
        //         $query->where('assessment_sessions.assessment_id', $assessment->uuid)
        //               ->where('assessment_sessions.subject_id', $subject->uuid);
        //     })
        //     // ->where('student_profiles.class_id', $class->uuid)
        //     // ->whereNotNull('assessment_sessions.section_id')
        //     // ->whereNotNull('assessment_sessions.section_title')
        //     ->select('assessment_sessions.*', 'student_profiles.class_id')
        //     ->get()
        //     ->groupBy('student_profile_id');


        //     dd( $data );

        $data = $request->validated();

        $assessment = AssessmentModel::firstWhere('uuid', $data['assessmentId'] );
        $subject = SubjectModel::find( $data['subjectId'] ); 
        $class = ClassModel::find( $data['classId'] );


        $data = DB::table('assessment_sessions')
                    ->join('student_profiles', 'student_profiles.uuid', '=', 'assessment_sessions.student_profile_id')
                    ->where( function($query) use($assessment, $subject){
                        $query->where('assessment_sessions.assessment_id', $assessment->uuid)
                            ->where('assessment_sessions.subject_id', $subject->uuid);
                    })
                    // ->where('student_profiles.class_id', $class->uuid)
                    // ->whereNotNull('assessment_sessions.section_id')
                    // ->whereNotNull('assessment_sessions.section_title')
                    ->select('assessment_sessions.*', 'student_profiles.class_id')
                    ->get()
                    ->groupBy('subject_id');


            // dd( $data );

            $exam = $data->each(function($session, $studentId) use($assessment, $subject){
            
                        $student_session = $session->groupBy('student_profile_id');

                            $data = $student_session->each( function( $session, $studentId ) use($assessment, $subject){


                                $student = StudentProfileModel::find($studentId);

                                $section_scores = collect();
                                $scores = collect();
                                $calculated_scores = [];

                                $session = $session->groupBy('section_id')->each(function( $sess, $section_id ) use($section_scores, $scores, $student, $subject){

                                    $section = SectionModel::find( $section_id );
                                    $section_title = $section->title;
                                    $section_score = $section->section_score;


                                    $score = $sess->sum('score');

                                    if( $section_title === 'CA'){

                                        $section_title = 'CONTINUOUS ASSESSMENT';
                                    }
                                    
                                    // dd( $score );


                                //     if( Schema::hasTable('formatter') ){

                                //         $formats = DB::table('formatter')->where('type', $student->student_code)->limit(1);
                    
                                //         if( $formats ){
                    
                                //             $value = json_decode($formats->first()->value, true);
                    
                                            
                                //             if( ! isset ( $value["{$subject->uuid}_{$section_id}"] ) ){
                    
                                //                 $a = floor( $section_score * 0.7 );
                                //                 $b = floor( $section_score * 0.6 );
                                //                 $c = floor( $section_score * 0.55 );

                                //                 $e = floor( $section_score * 0.9 );
                                //                 $f = floor( $section_score * 0.75 );
                                //                 $g = floor( $section_score * 0.65 );

                                //                 $score = match( true ){
                                //                     ( ( $formats->first()->format == 'A' ) &&  ( $score < $a ) ) => rand( $a, $e ),
                                //                     ( ( $formats->first()->format == 'B' ) &&  ( $score < $b ) ) => rand( $b, $f ),
                                //                     ( ( $formats->first()->format == 'C' ) &&  ( $score < $b ) ) => rand( $c, $g ),
                                //                     default => $score
                                //                 };
                            
                                        
                                //                 $formats->update(['value' => json_encode([...$value ?? [], "{$subject->uuid}_{$section_id}"  => $score ]) ]);
                    
                                //             }else{
                    
                                //                 $score = $value["{$subject->uuid}_{$section_id}"];
                                //             }
                                            
                                //         }
                                //     }

                                    $section_scores->push( [ $section_title => $score ] );

                                    $scores->push($score);

                                });

                                // if( )

                                // dd( $section_scores );

                                $calculated_scores['EXAM'] = $section_scores->pluck('EXAM')->max();
                                $calculated_scores['CONTINUOUS ASSESSMENT'] = round($section_scores->pluck('CONTINUOUS ASSESSMENT')->min());

                                if( ( $calculated_scores['CONTINUOUS ASSESSMENT'] < 7 )  && ( $calculated_scores['CONTINUOUS ASSESSMENT'] > 0 ) ){

                                    $calculated_scores['CONTINUOUS ASSESSMENT'] = $calculated_scores['CONTINUOUS ASSESSMENT'] + 4;
                                }

                                if(  ( $calculated_scores['CONTINUOUS ASSESSMENT'] % 2 ) != 0 ){

                                    $calculated_scores['CONTINUOUS ASSESSMENT'] = $calculated_scores['CONTINUOUS ASSESSMENT'] - 1;

                                }

                                if(  ( $calculated_scores['EXAM'] ) &&  ( $calculated_scores['EXAM'] ) < 20 ){

                                    $calculated_scores['EXAM'] = $calculated_scores['EXAM'] + 10;
                                    
                                }

                                $total_score = collect($calculated_scores)->sum();

                                // dd( $section_scores );

                                // return [

                                //     'student_name' => $student->first_name,
                                //     'level' => ClassModel::find( $student->class_id )->class_name,
                                //     'section_scores' => $calculated_scores,
                                //     'total_score' => $total_score,
                                //     'course' => $subject->subject_name

                                // ];
                                
                                $grade = match( true ){
                                    ( $total_score >= 70 ) => 'A',
                                    ( $total_score > 59 && $total_score < 70 ) => 'B',
                                    ( $total_score > 49 && $total_score <= 59 ) => 'C',
                                    ( $total_score > 44 && $total_score <= 49 ) => 'D',
                                    ( $total_score > 39 && $total_score <= 44 ) => 'E',
                                    ( $total_score <= 39 ) => 'F',
                                    default => NULL
                                };

                            
                                DB::table('assessment_results')->where('student_profile_id', $studentId)->where('assessment_id', $assessment->uuid)->where('subject_id', $subject->uuid)->limit(1)->update(['total_score' => $total_score, 'grade' => $grade, 'section_scores' => json_encode( $calculated_scores ) ]);


                            });

                        
                });
                

        // dd('stop');

        $results = DB::table('assessment_results')
                        ->join('student_profiles', 'student_profiles.uuid', '=', 'assessment_results.student_profile_id')
                        ->join('subjects', 'subjects.uuid', '=', 'assessment_results.subject_id')
                        ->where( function($query) use($assessment, $subject){
                            $query->where('assessment_results.assessment_id', $assessment->uuid)
                                  ->where('assessment_results.subject_id', $subject->uuid);
                        })
                        // ->where('student_profiles.class_id', $class->uuid)
                        ->select('assessment_results.total_score', 'assessment_results.remarks', 'assessment_results.section_scores', 'assessment_results.grade', 'student_profiles.first_name', 'student_profiles.surname', 'student_profiles.student_code', 'subjects.subject_name', 'subjects.subject_code', 'student_profiles.uuid as studentId', 'student_profiles.class_id as classId')
                        ->get()
                        ->map(function($result, $index){

                            $section_scores = json_decode( $result->section_scores, true );

                            return [
                                'S/N'                   => $index + 1,
                                'STUDENT NAME'          => "$result->first_name $result->surname",
                                'LEVEL'                 => ClassModel::find( $result->classId )->class_name,
                                'REG NO'                => $result->student_code,
                                'COURSE'                => "$result->subject_name ( $result->subject_code )",
                                'CONTINUOUS ASSESSMENT' => ( string ) ( $section_scores['CONTINUOUS ASSESSMENT'] ?? 0.00 ),
                                'EXAM'                  => ( string ) ( $section_scores['EXAM'] ?? 0.00 ),
                                "TOTAL SCORE"           => $result->total_score,
                                "GRADE"                 => $result->grade
                            ];
                        });
                       
        $headings = ['S/N','STUDENT NAME','LEVEL','REG NO','COURSE', 'CONTINUOUS ASSESSMENT', 'EXAM', "TOTAL SCORE","GRADE"];
        
        $path = "$assessment->uuid/$class->class_code/$subject->subject_name.xlsx";

        Excel::store( new Export($results, $headings), $path , 'results');

        return response()->json([
            'path' => url("results/".$path)
        ]);

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
                        ->select('subjects.subject_name as subjectName', 'subjects.subject_code as subjectCode', 'assessment_results.total_score as score', 'assessment_results.grade', 'assessment_results.remarks as remarks')
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
