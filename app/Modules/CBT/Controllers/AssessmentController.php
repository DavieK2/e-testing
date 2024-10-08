<?php

namespace App\Modules\CBT\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\CBT\Features\AssessmentsListFeature;
use App\Modules\CBT\Features\CreateAssessmentFeature;
use App\Modules\CBT\Features\CreateQuizFeature;
use App\Modules\CBT\Features\EditQuizFeature;
use App\Modules\CBT\Features\GetAssessmentClassesFeature;
use App\Modules\CBT\Features\GetAssessmentFeature;
use App\Modules\CBT\Features\GetAssessmentQuestionsFeature;
use App\Modules\CBT\Features\GetAssessmentSubjectsFeature;
use App\Modules\CBT\Features\GetAssignedAssessmentFeature;
use App\Modules\CBT\Features\GetPublishedAssessmentFeature;
use App\Modules\CBT\Features\UpdateAssessmentFeature;
use App\Modules\CBT\Features\UpdateQuizFeature;
use App\Modules\CBT\Models\AssessmentModel;
use App\Modules\CBT\Models\QuestionBankModel;
use App\Modules\CBT\Models\SectionModel;
use App\Modules\CBT\Requests\AssessmentListRequest;
use App\Modules\CBT\Requests\AssignClassesToAssessmentRequest;
use App\Modules\CBT\Requests\CompleteAssessmentRequest;
use App\Modules\CBT\Requests\CreateAssessmentQuestionSectionRequest;
use App\Modules\CBT\Requests\CreateAssessmentRequest;
use App\Modules\CBT\Requests\CreateQuizRequest;
use App\Modules\CBT\Requests\GetAssessmentQuestionSectionRequest;
use App\Modules\CBT\Requests\GetAssessmentSubjectRequest;
use App\Modules\CBT\Requests\PublishAssessmentRequest;
use App\Modules\CBT\Requests\PublishTermlyAssessmentRequest;
use App\Modules\CBT\Requests\UpdateAssessmentRequest;
use App\Modules\SchoolManager\Models\ClassModel;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class AssessmentController extends Controller
{
    public function index(AssessmentListRequest $request) : JsonResource
    {
        return $this->serve( new AssessmentsListFeature(), $request->validated() );
    }

    public function create(CreateAssessmentRequest $request) : JsonResource
    {
        return $this->serve( new CreateAssessmentFeature(), $request->validated() );
    }

    public function createQuiz(CreateQuizRequest $request) : JsonResource
    {
       return $this->serve( new CreateQuizFeature(), $request->validated() );
    }

    public function editQuiz(AssessmentModel $assessment) : JsonResource
    {
        return $this->serve( new EditQuizFeature($assessment) );
    }

    public function updateQuiz(AssessmentModel $assessment, CreateQuizRequest $request) : JsonResource
    {
        return $this->serve( new UpdateQuizFeature($assessment), $request->validated() );
    }

    public function publish(PublishAssessmentRequest $request) : JsonResource
    {
        return $this->serve( new UpdateAssessmentFeature(), $request->validated() );
    }

    public function show(AssessmentModel $assessment)
    {
        return $this->serve( new GetAssessmentFeature($assessment) );
    }

    public function complete(CompleteAssessmentRequest $request)
    {
        return $this->serve( new CreateAssessmentFeature(), $request->validated() );
    }

    public function update(UpdateAssessmentRequest $request)
    {
        return $this->serve( new UpdateAssessmentFeature(), $request->validated() );
    }

    public function addClassesToAssessment(AssignClassesToAssessmentRequest $request)
    {
        return $this->serve( new CreateAssessmentFeature(), $request->validated() );
    }

    public function getAssessmentClasses(AssessmentModel $assessment)
    {
        return $this->serve( new GetAssessmentClassesFeature($assessment) );
    }

    public function getAssessmentSubjects(AssessmentModel $assessment, GetAssessmentSubjectRequest $request)
    {
        return $this->serve( new GetAssessmentSubjectsFeature($assessment), $request->validated() );
    }

    public function getAssessmentQuestions(AssessmentModel $assessment)
    {
        return $this->serve( new GetAssessmentQuestionsFeature($assessment) );
    }

    public function getPublishedAssessments()
    {
        return $this->serve( new GetPublishedAssessmentFeature() );
    }

    public function getAssignedAssessments()
    {
        return $this->serve( new GetAssignedAssessmentFeature() );
    }

    public function publishTermly(PublishTermlyAssessmentRequest $request)
    {
        $data = $request->validated();

        $assessment = AssessmentModel::firstWhere('uuid', $data['assessmentId']);

        $class = ClassModel::firstWhere('class_code', $data['classId'])->uuid;

        DB::table('assessment_subjects')->where(fn($query) => $query->where('assessment_id', $assessment->uuid)->where('subject_id', $data['subjectId'])->where('class_id', $class))
            ->limit(1)
            ->update([ 'is_published' => $data['shouldPublish'] ]); 

        return response()->json([
            'message' => 'Published Success', 
            'published' => $data['shouldPublish'] ? 'Published' : 'Unpublished' 
        ]);
    }

    public function getQuestionBanks(AssessmentModel $assessment)
    {
        $is_assessment_QB = request('isAssessmentQB');

        $question_banks = QuestionBankModel::where('question_banks.assessment_id', $assessment->uuid)
                                            ->join('users', 'users.uuid', '=', 'question_banks.user_id')
                                            ->leftJoin('subjects', 'subjects.uuid', '=', 'question_banks.subject_id')
                                            ->select('question_banks.*', 'subjects.subject_name', 'subjects.subject_code', 'users.fullname');
              
        if( $is_assessment_QB ){

            $question_banks->where('is_assessment_question_bank', true);

        }else{

            $question_banks->where('is_assessment_question_bank', false);
        }

        $question_banks = $question_banks->get();
        
        $class = request('class');
        $subject = request('subject');
      

        if( $subject ){
            $question_banks = $question_banks->filter( fn( $question_bank ) => ( $question_bank->subject_id == $subject )  );
        }

        // if( $class ){

        //     $question_banks = $question_banks->filter( fn( $question_bank ) => ( in_array( $class, json_decode($question_bank->classes, true ) ?? [] ) ) );
        // }

        $question_banks = $question_banks->map( function( $question_bank ){

            return [
                'questionBankId' => $question_bank->uuid,
                'subject'        => $question_bank->subject_name,
                'subjectCode'    => $question_bank->subject_code,
                'totalQuestions' => $question_bank->questions()->count(),
                'teacher'        => $question_bank->fullname,
                'isVisible'      => true,
                'classes'        => collect(json_decode($question_bank->classes, true))->flatMap( fn($class) => [ ClassModel::firstWhere('class_code', $class)->class_name ] )->toArray(),
            ];

        })->values()->toArray();

        

        return response()->json([
            'data' => $question_banks
        ]);
    }


    public function editQuestionBank(QuestionBankModel $question_bank)
    {
        
    }

    public function createAssessmentSection(AssessmentModel $assessment, CreateAssessmentQuestionSectionRequest $request)
    {
        $data = $request->validated();

        SectionModel::create([
            'class_id'          => ClassModel::firstWhere('class_code', $data['classId'] ?? null)?->uuid,
            'subject_id'        => $data['subjectId'] ?? null,
            'title'             => $data['title'],
            'assessment_id'     => $assessment->uuid,
            'section_code'      => Str::random(6),
            'question_type'     => $data['questionType'],
            'description'       => $data['description'],
            'section_score'     => $data['sectionScore'],
            'total_questions'   => $data['totalQuestions'],
        ]);

        return response()->json([
            'message' => 'Section Successfully Created'
        ]);
    }

    public function getAssessmentSections(AssessmentModel $assessment, GetAssessmentQuestionSectionRequest $request)
    {
        $data = $request->validated();

        $sections = SectionModel::where('assessment_id', $assessment->uuid);
                               
        if( isset( $data['subjectId'] ) )  $sections->where('subject_id', $data['subjectId']);
        
        $sections = $sections->get();
        
        if( isset( $data['classId'] )  ) {

            $sections = $sections->filter( fn($section) => in_array( $data['classId'], ( json_decode( ( $section->classes ?? '' ), true ) ?? [] ) ) );
        }
      
        return response()->json([
            'data' => $sections->map( fn($section) => ['sectionId' => $section->uuid, 'sectionTitle' => $section->title, 'sectionDescription' => $section->description, 'questionType' => $section->question_type ])
        ]);

    }
}
