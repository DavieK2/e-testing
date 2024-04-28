<?php

namespace App\Modules\CBT\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\CBT\Models\QuestionModel;

class GetTeacherAssessmentQuestionTasks extends BaseTasks{

    public function getQuestions()
    {
        $questions = QuestionModel::where( fn($query) => $query->where('questions.question_bank_id', $this->item['question_bank']->uuid) )
                                    ->leftJoin('sections', 'sections.uuid', '=', 'questions.section_id')
                                    ->leftJoin('topics', 'topics.uuid', '=', 'questions.topic_id')
                                    ->select('questions.correct_answer', 'questions.question_score', 'questions.options', 'questions.question', 'questions.question_type', 'questions.question_bank_id', 'questions.uuid', 'topics.uuid as topicId', 'sections.uuid as sectionId', 'sections.title as sectionTitle');

        return new static( [ ...$this->item, 'query' => $questions ]);
    }
    
}