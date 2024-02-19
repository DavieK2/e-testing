<?php

namespace App\Modules\CBT\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\CBT\Models\QuestionBankModel;
use App\Modules\CBT\Models\SectionModel;
use App\Modules\CBT\Models\TopicModel;

class UpdateQuestionTask extends BaseTasks{

    public function updateQuestion()
    {

        $task = new CreateQuestionTasks();
        
        $questionData = json_encode( $task->formatQuestionJSON( json_decode( $this->item['question'], true ) )  );

        $options = $task->formatQuestionOptions($this->item['options'], $this->item['correctAnswer']);

        $questionBankId = QuestionBankModel::firstWhere('uuid', $this->item['questionBankId'] ?? null )?->uuid;
        $topicId = TopicModel::firstWhere('uuid', $this->item['topicId'] ?? null )?->uuid;
        $sectionId = SectionModel::firstWhere('uuid', $this->item['sectionId'] ?? null )?->uuid;
       

        $this->item['oldQuestion']->update([
            'question'          => $questionData,
            'options'           => $options['options'],
            'correct_answer'    => $options['correctAnswer'],
            'question_score'    => $this->item['questionScore'],
            'question_bank_id'  => $questionBankId,
            'topic_id'          => $topicId,
            'section_id'        => $sectionId,
        ]);

        return new static( $this->item );
    }
    
}