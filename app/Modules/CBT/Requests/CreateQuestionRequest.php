<?php

namespace App\Modules\CBT\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateQuestionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'question' => 'required|string',
            'options' => ['required', 'array'],
            'correctAnswer' => ['required','string', function($attr, $val, $fail){
                if( ! in_array($val, request('options')) ){
                    return $fail('The correct answer provided is not part of the options list provided');
                }
            }],
            'questionScore' => 'required|integer'
        ];
    }
}
