<?php

namespace App\Modules\CBT\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\CBT\Models\QuestionBankModel;
use App\Modules\CBT\Models\QuestionModel;
use App\Modules\CBT\Models\SectionModel;
use App\Modules\CBT\Models\TopicModel;
use App\Modules\SchoolManager\Models\ClassModel;
use App\Modules\UserManager\Models\UserModel;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CreateQuestionTasks extends BaseTasks{

    public function createQuestion()
    {
        
        $questionData = json_decode($this->item['question'], true);
        $questionContent = [];
        $options = [];

        if( isset( $questionData['type']) ){

            foreach( $questionData['content']['content'] as $content){

                if( $content['type'] === 'image'){

                    $img = Image::make($content['attrs']['src'])->resize(500, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    $imgName = 'question_images/'. Str::random(). '.jpg';

                    $img->save(public_path($imgName), 90);

                    $content['attrs']['src'] = $imgName;
                }

                $questionContent[] = $content;
            }
        
        }

        $questionData['content']['content'] = $questionContent;

        $questionData = json_encode($questionData);
        // if( ! in_array($this->item['correctAnswer'], $this->item['options']) ){
        //     throw ValidationException::withMessages(['message' => 'The correct answer provided is not part of the options list provided']);
        // }

        foreach( $this->item['options'] as $option ){

            if( $option['type'] === 'image' ){

                $img = Image::make($option['content'])->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $imgName = 'question_images/'. Str::random(). '.jpg';

                $img->save(public_path($imgName), 90);

                if( $this->item['correctAnswer'] ===  $option['content'] ){

                    $this->item['correctAnswer'] = $imgName;
                }

                $option['content'] = $imgName;

            }

            $options[] = $option;
        }

        $questionBank = QuestionBankModel::firstWhere('uuid', $this->item['questionBankId'] ?? null );
        $topicId = TopicModel::firstWhere('uuid', $this->item['topicId'] ?? null )?->id;
        $sectionId = SectionModel::firstWhere('uuid', $this->item['sectionId'] ?? null )?->id;

        if( $questionBank ){

            $question = $this->saveQuestionToDatabase( $questionData, $options, $questionBank->id, $questionBank->subject_id, $topicId, $sectionId );
            

            foreach (json_decode($questionBank->classes, true ) as $class) {

                $classId = ClassModel::firstWhere('class_code', $class)->id;

                $question->classes()->syncWithoutDetaching( [ $classId => [ 'uuid' => Str::ulid() ] ] );
            }

        }else{

            $question = $this->saveQuestionToDatabase( $questionData, $options );
        }


        return new static( [ ...$this->item, 'questionId'=> $question->uuid ] );
    }
    
    protected function saveQuestionToDatabase($questionData, $options, $questionBankId = null, $subjectId = null, $topicId = null, $sectionId = null)
    {
        return QuestionModel::create([
                    'uuid'              => Str::ulid(),
                    'assessment_id'     => $this->item['assessment']->id,
                    'user_id'           => request()->user()->id,
                    'question'          => $questionData,
                    'options'           => $options,
                    'correct_answer'    => $this->item['correctAnswer'],
                    'question_score'    => $this->item['questionScore'] ?? 1,
                    'question_bank_id'  => $questionBankId,
                    'subject_id'        => $subjectId,
                    // 'class_id'          => ClassModel::firstWhere('class_code', $classId)?->id,
                    'topic_id'          => $topicId,
                    'section_id'        => $sectionId,
                ]);
    }
}