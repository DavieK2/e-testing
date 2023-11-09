<?php

namespace App\Modules\CBT\Requests;

use Illuminate\Foundation\Http\FormRequest;

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

        return [
            'questionId'        => 'required|exists:questions,uuid',
            'question'          => 'required|string',
            'options'           => ['required', 'array'],
            'correctAnswer'     => ['required','string', function($attr, $val, $fail) use($options){
                if( ! in_array( $val, $options ) ){
                    return $fail('The correct answer provided is not part of the options list provided');
                }
            }],
            'questionScore'     => 'required|integer'
        ];
    }
}
