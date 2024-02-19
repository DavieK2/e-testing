<?php

namespace App\Modules\CBT\Requests;

use App\Modules\CBT\Models\AssessmentModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MassAssignQuestionsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $assessment = $this->route('assessment');
       
        return [
            'sectionId'     => [ Rule::requiredIf( ! $assessment->is_standalone ), 'exists:sections,uuid' ],
            'questions'     => 'required|array',
            'subjectId'     => 'required|exists:subjects,uuid',
            'classId'       => 'required|exists:classes,class_code',
            'questions.*'   => 'exists:questions,uuid'
        ];
    }
}
