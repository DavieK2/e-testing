<?php

namespace App\Modules\CBT\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\CBT\Models\QuestionModel;

class UpdateQuestionTask extends BaseTasks{

    public function updateQuestion()
    {
        $question = QuestionModel::where('uuid', $this->item['questionId'])->firstOrFail();

        $question->update([
            'question' => $this->item['question'],
            'options' => $this->item['options'],
            'correct_answer' => $this->item['correctAnswer'],
            'question_score' => $this->item['questionScore']
        ]);

        return new static( $this->item );
    }
    
}