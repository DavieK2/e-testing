<?php

namespace App\Modules\CBT\Requests;

use App\Modules\CBT\Models\AssessmentModel;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class CreateQuestionBankRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title'         => [  Rule::requiredIf( AssessmentModel::find( request('assessmentId') )->is_standalone ) ],
            'assessmentId'  => 'required|exists:assessments,uuid',
            'subjectId'     => ['nullable','exists:subjects,uuid', Rule::requiredIf( ! AssessmentModel::find( request('assessmentId') )->is_standalone ) ],
            'classes'       => [ 'array', Rule::requiredIf( ( ! AssessmentModel::find( request('assessmentId') )->is_standalone ) && ! request()->user()->is_teacher )  ],
            'classes.*'     => 'exists:classes,class_code'
        ];
    }
}
