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

        DB::table('assessment_subjects')
                ->updateOrInsert(
                    [ 'assessment_id' => $assessment->id, 'subject_id' => $data['subjectId'], 'class_id' => $class ], 
                    [
                        'is_published' => $data['shouldPublish'],
                    ]);

        return response()->json([
            'message' => 'Publised Success', 
            'published' => $data['shouldPublish'] ? 'Published' : 'Unpublished' 
        ]);
    }

    
}
