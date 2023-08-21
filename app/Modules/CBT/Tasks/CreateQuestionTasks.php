<?php

namespace App\Modules\CBT\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\CBT\Models\QuestionModel;
use App\Modules\UserManager\Models\UserModel;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CreateQuestionTasks extends BaseTasks{

    public function createQuestion()
    {
        // if( ! in_array($this->item['correctAnswer'], $this->item['options']) ){
        //     throw ValidationException::withMessages(['message' => 'The correct answer provided is not part of the options list provided']);
        // }

        $question = QuestionModel::create([
                        'uuid' => Str::uuid(),
                        'assessment_id' => $this->item['assessment']->id,
                        'user_id' => UserModel::find(1)->id,
                        'question' => $this->item['question'],
                        'options' => $this->item['options'],
                        'correct_answer' => $this->item['correctAnswer'],
                        'question_score' => $this->item['questionScore']
                    ]);

        return new static( [...$this->item, 'questionId'=> $question->uuid ] );
    }
    
}