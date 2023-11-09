<?php

namespace App\Modules\CBT\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\CBT\Models\QuestionModel;
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

        
        $question = QuestionModel::create([
                        'uuid'              => Str::uuid(),
                        'assessment_id'     => $this->item['assessment']->id,
                        'user_id'           => UserModel::find(1)->id,
                        'question'          => $questionData,
                        'options'           => $options,
                        'correct_answer'    => $this->item['correctAnswer'],
                        'question_score'    => $this->item['questionScore'] ?? 2,
                        'subject_id'        => $this->item['subjectId'] ?? null,
                        'class_id'          => ClassModel::firstWhere('class_code', $this->item['classId'] ?? null)?->id,
                    ]);


        return new static( [ ...$this->item, 'questionId'=> $question->uuid ] );
    }
    
}