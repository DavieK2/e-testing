<?php

namespace App\Modules\CBT\Requests;

use App\Modules\CBT\Models\AssessmentModel;
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
        
        $assessment = AssessmentModel::find( $this->route('question')?->assessment_id );

        return [
            'question'          => 'required|string',
            'options'           => ['required', 'array'],
            'correctAnswer'     => ['required','string', function($attr, $val, $fail) use($options){
                                    if( ! in_array( $val, $options ) ){
                                        $fail('The correct answer provided is not part of the options list provided');
                                        return false;
                                    }
                                }],
            'questionScore'     => 'required|integer',
            'questionBankId'    => [ Rule::requiredIf( fn() => ! $assessment?->is_standalone ), 'exists:question_banks,uuid'],
            'sectionId'         => [ Rule::requiredIf( fn() => ! $assessment?->is_standalone ), 'exists:sections,uuid'],
            'topicId'           => [ Rule::requiredIf( fn() => ! $assessment?->is_standalone ), 'exists:topics,uuid'],
        ];
    }
}
