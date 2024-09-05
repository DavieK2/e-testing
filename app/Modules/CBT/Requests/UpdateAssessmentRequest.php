<?php

namespace App\Modules\CBT\Requests;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class UpdateAssessmentRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'assessmentId'      => 'required|exists:assessments,uuid',
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
