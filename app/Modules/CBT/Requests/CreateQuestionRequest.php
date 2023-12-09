<?php

namespace App\Modules\CBT\Requests;

use App\Http\Requests\BaseRequest;
use App\Modules\CBT\Models\QuestionModel;
use Illuminate\Validation\Rule;

class CreateQuestionRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {        
        $options = request('options');
        $options = collect($options)->flatMap(fn($option) => [ $option['content'] ?? $option ])->toArray();
        $question_type = request('questionType');

        return [
            'question'          => 'required|string',
            'options'           => ['required', 'array'],
            'correctAnswer'     => [function($attr, $val, $fail) use($options, $question_type){

                                    if( $question_type != 'theory' && is_null( $val ) ){
                                        return $fail('Please provide the correct answer to the question');
                                    }
                                    if( $question_type != 'theory' && ! is_string( $val ) ){
                                        return $fail('The correct answer should only be text values');
                                    }
                                    if( $question_type != 'theory' && ! in_array( $val, $options ) ){
                                        return $fail('The correct answer provided is not part of the options list provided');
                                    }
                                   
                                }],
            'questionType'      => 'required|in:'.implode(',', QuestionModel::QUESTION_TYPES),
            'questionScore'     => 'required|integer',
            'questionBankId'    => [ Rule::requiredIf( fn() => ! $this->route('assessment')->is_standalone ), 'exists:question_banks,uuid'],
            'sectionId'         => [ Rule::requiredIf( fn() => ! $this->route('assessment')->is_standalone ), 'exists:sections,uuid'],
            'topicId'           => [ Rule::requiredIf( fn() => (! $this->route('assessment')->is_standalone) && request()->user()->is_teacher ), 'exists:topics,uuid'],
        ];
    }
}
