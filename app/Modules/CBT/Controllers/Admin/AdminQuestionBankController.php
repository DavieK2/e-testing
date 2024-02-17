<?php

namespace App\Modules\CBT\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\CBT\Models\AssessmentModel;
use App\Modules\CBT\Requests\CreateQuestionBankRequest;
use App\Modules\CBT\Requests\UpdateQuestionBankClassesRequest;
use App\Modules\CBT\Tasks\QuestionBankTasks;
use App\Modules\SchoolManager\Models\SubjectModel;
use App\Modules\SchoolManager\Resources\ClassListCollection;
use App\Modules\SchoolManager\Resources\SubjectListCollection;

class AdminQuestionBankController extends Controller
{
    public function getAssessmentSubjectClasses(AssessmentModel $assessment, SubjectModel $subject)
    {        
        $assessment_classes = $assessment->classes()->get();
        $subject_classes = $subject->classes()->get();
        $classes = $assessment_classes->intersect($subject_classes);

        return response()->json([
            'data' => new ClassListCollection($classes)
        ]);
    }

    public function getAssessmentSubjects(AssessmentModel $assessment)
    {        
        $subjects = $assessment->subjects()->get()->unique('subject_code');

        return response()->json([
            'data' => new SubjectListCollection($subjects)
        ]);
    }

    public function createQuestionBank(CreateQuestionBankRequest $request )
    {
        $task = ( new QuestionBankTasks() )->start( $request->validated() )->createQuestionBank()->addClassesToQuestionBank();

        return response()->json([
            'questionBankId' => $task->only(['questionBankId'])->get()['questionBankId'],
            'message' => 'Question Bank Successfully Created'
        ]);
    }

    public function updateQuestionBankClasses(UpdateQuestionBankClassesRequest $request )
    {
        $task = ( new QuestionBankTasks() )->start( $request->validated() )->addClassesToQuestionBank();

        return response()->json([
            'message' => 'Question Bank Successfully Updated'
        ]);
    }
}