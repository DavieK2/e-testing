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
        $assessment = AssessmentModel::find( $this->route('question_bank')->assessment_id );
       
        return [
            'sectionId'     => [ Rule::requiredIf( ! $assessment->is_standalone ), 'exists:sections,uuid' ],
            'questions'     => 'required|array',
            'questions.*'   => 'exists:questions,uuid'
        ];
    }
}
