<?php

namespace App\Modules\CBT\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\CBT\Models\AssessmentModel;
use App\Modules\CBT\Models\QuestionModel;
use App\Modules\SchoolManager\Models\ClassModel;
use App\Modules\SchoolManager\Models\SubjectModel;

class GetTeacherAssessmentQuestionTasks extends BaseTasks{

    public function getQuestions()
    {
        $assessmentId = AssessmentModel::firstWhere('uuid', $this->item['assessmentId'])->id;
        $subjectId = SubjectModel::find($this->item['subjectId'])->id;
        $classId = ClassModel::firstWhere('class_code', $this->item['classId'])->id;

        // dd($subjectId);
        $questions = QuestionModel::where(fn($query) => $query->where('assessment_id', $assessmentId)->where('class_id', $classId)->where('subject_id', $subjectId));

        return new static( [ ...$this->item, 'query' => $questions ]);
    }
    
}