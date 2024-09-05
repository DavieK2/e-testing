<?php

namespace App\Modules\CBT\Resources;

use App\Http\Resources\BaseResource;
use App\Modules\CBT\Enums\QuizTakersEnum;
use App\Modules\CBT\Facades\AssessmentTasks;
use App\Modules\SchoolManager\Resources\ClassListCollection;
use App\Modules\SchoolManager\Resources\GetTeachersListCollection;
use App\Modules\SchoolManager\Resources\StudentListCollection;

class QuizResource extends BaseResource
{
    public function toArray($request)
    {
        
        return [

            'title'                             => $this->title,
            'assessmentTypeId'                  => $this->assessment_type_id,
            'assessmentType'                    => $this->assessmentType->name,
            'duration'                          => ( $this->assessment_duration ) / 60,
            'startDate'                         => $this->start_date,
            'endDate'                           => $this->end_date,
            'assessmentDescription'             => $this->description,
            'contributorType'                   => $this->contributor_type,
            'quizTakerType'                     => $this->quiz_taker_type,
            'contributors'                      => AssessmentTasks::assessment($this->resource)->getQuizContributors()->all()->formatResponse( formatter: GetTeachersListCollection::class ),
            'quizTakers'                        => AssessmentTasks::assessment($this->resource)
                                                                   ->getQuizTakers()
                                                                   ->all()
                                                                   ->formatResponse( 
                                                                        formatter: match( $this->quiz_taker_type ){
                                                                            QuizTakersEnum::SELECTED_CLASSES->value     =>  ClassListCollection::class,
                                                                            QuizTakersEnum::SELECTED_STUDENTS->value    =>  StudentListCollection::class,
                                                                            default                                     =>  null,
                                                                        },
                                                                        formatterOptions: match( $this->quiz_taker_type ){
                                                                            QuizTakersEnum::SELECTED_STUDENTS->value    =>  ['more_student_info' => false],
                                                                            default                                     =>  [],
                                                                        }
                                                                    ),
            'shouldDisplayResults'              => $this->should_display_results,
            'shouldGradeWithAssessmentTypeMaxScore' => $this->grade_with_assessment_type_max_score,
            'shouldShuffleQuestions'             => $this->should_shuffle_questions
            
        ];
    }
}
