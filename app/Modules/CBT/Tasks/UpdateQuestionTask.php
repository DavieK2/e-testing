<?php

namespace App\Modules\CBT\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\CBT\Models\QuestionBankModel;
use App\Modules\CBT\Models\SectionModel;
use App\Modules\CBT\Models\TopicModel;
use App\Modules\SchoolManager\Models\ClassModel;

class UpdateQuestionTask extends BaseTasks{

    public function updateQuestion()
    {

        $task = new CreateQuestionTasks();
        
        $questionData = json_encode( $task->formatQuestionJSON( json_decode( $this->item['question'], true ) )  );

        $options = $task->formatQuestionOptions( $this->item['options'], $this->item['correctAnswer'] );

        $questionBank = QuestionBankModel::find( $this->item['questionBankId'] ?? null );
        $questionBankId = $questionBank?->uuid;
        $questionBankClasses = json_decode($questionBank?->classes, true) ?? [];
        $topicId = TopicModel::find( $this->item['topicId'] ?? null )?->uuid;
        $sectionId = SectionModel::find( $this->item['sectionId'] ?? null )?->uuid;

        $question = $this->item['oldQuestion'];
        
        $assessment = $question->assessment;
        $subjectId = $this->item['subjectId'];
        
        $data = [
                    'question'          => $questionData,
                    'options'           => $options['options'],
                    'correct_answer'    => $options['correctAnswer'],
                    'question_score'    => $this->item['questionScore'],
                    'question_bank_id'  => $questionBankId,
                    'topic_id'          => $topicId,
                ];
        
        if( ! $this->item['assigned'] ) $data['section_id'] = $sectionId;
        
        $question->update($data);

        if( ! request()->user()->is_admin ) return new static( $this->item );

        if( $this->item['assigned'] ){

            $assessment->getAssessmentQuestion($question->uuid, $subjectId, ( $this->item['classId'] ?? null ) )->update(['section_id' => $sectionId ]);

            if( $assessment->hasCachedQuestions( $subjectId, ( $this->item['classId'] ?? null ) ) ) $assessment->cacheAssessmentQuestions( $subjectId, ( $this->item['classId'] ?? null ) );

        }

        if( $this->item['questionBank'] ){

            foreach ( $questionBankClasses as $class )  {

                if( $assessment->hasCachedQuestions( $subjectId, $class ) ) $assessment->cacheAssessmentQuestions( $subjectId, $class );
            }
        }
        
       
        return new static( $this->item );
    }
    
}