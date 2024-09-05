<?php

namespace App\Modules\CBT\Requests;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class SaveStudentExamSessionResponsesRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'questionId'        => 'required|exists:questions,uuid',
            'subjectId'         => [ Rule::requiredIf( ! $this->route('assessment')->is_standalone ) ],
            'sectionId'         => [ Rule::requiredIf( ! $this->route('assessment')->is_standalone ) ],
            'sectionTitle'      => [ Rule::requiredIf( ! $this->route('assessment')->is_standalone ) ],
            'studentAnswer'     => 'nullable',
            'markedForReview'   => 'required',
        ];
    }
}
