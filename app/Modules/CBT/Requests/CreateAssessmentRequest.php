<?php

namespace App\Modules\CBT\Requests;

use App\Modules\CBT\Constants\CBTConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class CreateAssessmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

  
    public function rules()
    {
        return [
            'step'              => 'required|in:'.implode(", ", CBTConstants::ASSESSMENT_STEPS),
            'title'             => 'required|string',
            'description'       => [ Rule::requiredIf( request('isStandalone') == true ), 'string'],
            'startDate'         => [ Rule::requiredIf( request('isStandalone') == true ), 'string'],
            'endDate'           => [ Rule::requiredIf( request('isStandalone') == true ), 'string'],
            'duration'          => [ Rule::requiredIf( request('isStandalone') == true ), 'integer'],
            'assessmentTypeId'  => 'required|exists:assessment_types,uuid',
            'isStandalone'      => 'required|boolean',
            'academicSessionId' => [ Rule::requiredIf( request('isStandalone') == false ), 'exists:academic_sessions,uuid' ],
            'schoolTermId'      => [ Rule::requiredIf( request('isStandalone') == false ), 'exists:school_terms,uuid' ]
        ];
    }
}
