<?php

namespace App\Modules\CBT\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\CBT\Features\AssessmentsListFeature;
use App\Modules\CBT\Features\CreateAssessmentFeature;
use App\Modules\CBT\Features\GetAssessmentClassesFeature;
use App\Modules\CBT\Features\GetAssessmentFeature;
use App\Modules\CBT\Features\GetAssessmentQuestionsFeature;
use App\Modules\CBT\Features\GetAssessmentSubjectsFeature;
use App\Modules\CBT\Features\GetPublishedAssessmentFeature;
use App\Modules\CBT\Features\UpdateAssessmentFeature;
use App\Modules\CBT\Models\AssessmentModel;
use App\Modules\CBT\Models\QuestionBankModel;
use App\Modules\CBT\Requests\AssessmentListRequest;
use App\Modules\CBT\Requests\AssignClassesToAssessmentRequest;
use App\Modules\CBT\Requests\CompleteAssessmentRequest;
use App\Modules\CBT\Requests\CreateAssessmentRequest;
use App\Modules\CBT\Requests\GetAssessmentSubjectRequest;
use App\Modules\CBT\Requests\PublishAssessmentRequest;
use App\Modules\CBT\Requests\PublishTermlyAssessmentRequest;
use App\Modules\CBT\Requests\UpdateAssessmentRequest;
use App\Modules\SchoolManager\Models\ClassModel;
use Illuminate\Support\Facades\DB;

class AssessmentController extends Controller
{
    public function index(AssessmentListRequest $request)
    {
        return $this->serve( new AssessmentsListFeature(), $request->validated() );
    }

    public function create(CreateAssessmentRequest $request)
    {
        return $this->serve( new CreateAssessmentFeature(), $request->validated() );
    }

    public function publish(PublishAssessmentRequest $request)
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

    public function publishTermly(PublishTermlyAssessmentRequest $request)
    {
        $data = $request->validated();

        $assessment = AssessmentModel::firstWhere('uuid', $data['assessmentId']);

        $class = ClassModel::firstWhere('class_code', $data['classId'])->id;

        DB::table('assessment_subjects')->where(fn($query) => $query->where('assessment_id', $assessment->id)->where('subject_id', $data['subjectId'])->where('class_id', $class))
            ->limit(1)
            ->update([ 'is_published' => $data['shouldPublish'] ]); 

        return response()->json([
            'message' => 'Published Success', 
            'published' => $data['shouldPublish'] ? 'Published' : 'Unpublished' 
        ]);
    }

    public function getQuestionBanks(AssessmentModel $assessment)
    {
        $question_banks = QuestionBankModel::where('question_banks.assessment_id', $assessment->id)
                                            ->join('users', 'users.id', '=', 'question_banks.user_id')
                                            ->join('subjects', 'subjects.id', '=', 'question_banks.user_id')
                                            ->select('question_banks.*', 'subjects.subject_name', 'subjects.subject_code', 'users.fullname')
                                            ->get();

        $question_banks = $question_banks->map(function($question_bank){

            return [
                'questionBankId' => $question_bank->uuid,
                'subject'        => $question_bank->subject_name,
                'subjectCode'    => $question_bank->subject_code,
                'totalQuestions' => $question_bank->questions()->count(),
                'teacher'        => $question_bank->fullname,
                'isVisible'      => true,
                'classes'        => collect(json_decode($question_bank->classes, true))->flatMap( fn($class) => [ ClassModel::firstWhere('class_code', $class)->class_name ] )->toArray(),
            ];
        });

        return response()->json([
            'data' => $question_banks
        ]);
    }

    
}
