<?php

namespace App\Modules\CBT\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuestionListRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'subjectId'    =>  [ Rule::requiredIf( ! $this->route('assessment')->is_standalone ), 'exists:subjects,id' ],
            'classId'      =>  [ Rule::requiredIf( ! $this->route('assessment')->is_standalone ), 'exists:classes,class_code' ],
            'assigned'     =>  'boolean',
            'filter'        =>  'json',
            'perPage'      =>  'required|int',
        ];
    }
}
