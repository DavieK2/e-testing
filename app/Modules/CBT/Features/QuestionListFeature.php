<?php

namespace App\Modules\CBT\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\CBT\Models\AssessmentModel;
use App\Modules\CBT\Resources\QuestionListCollection;
use App\Modules\CBT\Tasks\QuestionListTasks;

class QuestionListFeature extends FeatureContract {

    public function __construct(protected AssessmentModel $assessment){
        $this->tasks = new QuestionListTasks();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
        try {
            
            $builder = match(true){
                ( isset($args['assigned']) && ($args['assigned']) )     => $task->start([ ...$args, 'assessment' => $this->assessment ])->getAssignedQuestions(),
                default                                                 => $task->start([ ...$args, 'assessment' => $this->assessment ])->getQuestions()
            };
            
            foreach($args as $key => $value){
                $builder = $builder->$key();
            }

            return $task::formatResponse( $builder, formatter: QuestionListCollection::class );

        } catch (\Throwable $th) {
            
            throw $th;
        }
    }
}