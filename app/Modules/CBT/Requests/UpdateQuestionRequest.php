<?php

namespace App\Modules\CBT\Requests;

use App\Modules\CBT\Models\AssessmentModel;
use App\Modules\CBT\Models\QuestionModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateQuestionRequest extends FormRequest
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
        
        $assessment = AssessmentModel::find( $this->route('question')?->assessment_id );

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
            'questionScore'     => 'required|numeric',
            'questionType'      => 'required|in:'.implode(',', QuestionModel::QUESTION_TYPES),
            'questionBankId'    => [ Rule::requiredIf( fn() => ! $assessment?->is_standalone ), 'exists:question_banks,uuid'],
            'sectionId'         => [ Rule::requiredIf( fn() => ! $assessment?->is_standalone ), 'exists:sections,uuid'],
            'topicId'           => ['nullable', 'exists:topics,uuid'],
            'subjectId'         => 'required|exists:subjects,uuid',
            'assigned'          => 'required|boolean',
            'questionBank'      => 'nullable|boolean',
            'classId'           => 'nullable|exists:classes,class_code',
        ];
    }
}
