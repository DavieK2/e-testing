<?php

namespace App\Modules\CBT\Requests;

use App\Http\Requests\BaseRequest;
use App\Modules\CBT\Enums\QuizContributorsEnum;
use App\Modules\CBT\Enums\QuizTakersEnum;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CreateQuizRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $quizTakerType = request('quizTakerType');

        return [
            'title'             => ['required', 'string'],
            'description'       => ['required', 'string'],
            'startDate'         => ['required', 'string'],
            'endDate'           => ['required', 'string'],
            'duration'          => ['required', 'integer'],
            'assessmentTypeId'  => ['required', 'exists:assessment_types,uuid'],
            'contributorType'   => ['required', 'in:'.implode( ',', QuizContributorsEnum::getAllValues() )],
            'contributors'      => [ Rule::requiredIf( request('contributorType') === QuizContributorsEnum::SELECTED_TEACHERS->value ), 'array' ],
            'contributors.*'    => [ Rule::excludeIf( ! (request('contributorType') === QuizContributorsEnum::SELECTED_TEACHERS->value) ),  'string', 'exists:users,uuid'],
            'quizTakerType'     => ['required', 'in:'.implode( ',', QuizTakersEnum::getAllValues() )],
            'quizTakers'        => [ Rule::excludeIf( $quizTakerType === QuizTakersEnum::EVERYONE->value ), 'array', Rule::requiredIf( $quizTakerType === ( QuizTakersEnum::SELECTED_CLASSES->value) || $quizTakerType === ( QuizTakersEnum::SELECTED_STUDENTS->value) ), function( $attr, $val, $fail) use($quizTakerType) {
                                        
                                        if( $quizTakerType  === QuizTakersEnum::SELECTED_CLASSES->value ){
                                            
                                            $invalid = collect( $val )->diff( DB::table('classes')->whereIn('uuid', $val)->pluck('uuid') )
                                                                      ->flatMap( fn($id, $key) => ["$attr.$key is invalid"])
                                                                      ->implode(', ');

                                            if( ! empty($invalid) ) return $fail($invalid);
                                            
                                        }

                                        if( $quizTakerType === QuizTakersEnum::SELECTED_STUDENTS->value ){
                                            
                                            $invalid = collect( $val )->diff( DB::table('student_profiles')->whereIn('uuid', $val)->pluck('uuid') )
                                                                      ->flatMap( fn($id, $key) => ["$attr.$key is invalid"])
                                                                      ->implode(', ');

                                            if( ! empty($invalid) ) return $fail($invalid);
                                           
                                        }
                                }],
            'shouldDisplayResults'                  => 'required|boolean',
            'shouldGradeWithAssessmentTypeMaxScore' => 'required|boolean',
            'shouldShuffleQuestions'                 => 'required|boolean',
        ];
    }

}
