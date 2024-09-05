<?php

namespace App\Modules\CBT\Requests;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class GetStudentExamResponsesRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'subjectId' => [ Rule::requiredIf( ! $this->route('assessment')->is_standalone ), 'exists:subjects,subject_code' ],
        ];
    }
}
