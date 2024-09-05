<?php

namespace App\Modules\CBT\Requests;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class UnAssignQuestionFromAssessmentRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'questionId' => 'required|exists:questions,uuid',
            'subjectId'    =>  [ Rule::requiredIf( ! $this->route('assessment')->is_standalone ), 'exists:subjects,uuid' ],
            'classId'      =>  [ Rule::requiredIf( ! $this->route('assessment')->is_standalone ), 'exists:classes,class_code' ],
        ];
    }
}
