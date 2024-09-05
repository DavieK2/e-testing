<?php

namespace App\Modules\CBT\Requests;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class GetAssessmentQuestionSectionRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $assessment = $this->route('assessment');

        return [
            'classId'       => [ Rule::requiredIf( ! $assessment->is_standalone ), 'exists:classes,class_code'],
            'subjectId'     => [ Rule::requiredIf( ! $assessment->is_standalone ), 'exists:subjects,uuid'],
        ];
    }
}
