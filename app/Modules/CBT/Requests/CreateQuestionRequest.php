<?php

namespace App\Modules\CBT\Requests;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class CreateQuestionRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // dd( request()->all());

        $options = request('options');
        $options = collect($options)->flatMap(fn($option) => [ $option['content'] ?? $option ])->toArray();

        return [
            'question' => 'required|string',
            'options' => ['required', 'array'],
            'correctAnswer' => ['required','string', function($attr, $val, $fail) use($options){
                if( ! in_array( $val, $options ) ){
                    return $fail('The correct answer provided is not part of the options list provided');
                }
            }],
            'questionScore' => 'required|integer',
            'subjectId'     => [ Rule::requiredIf( fn() => ! $this->route('assessment')->is_standalone )],
            'classId'       => [ Rule::requiredIf( fn() => ! $this->route('assessment')->is_standalone )]
        ];
    }
}
