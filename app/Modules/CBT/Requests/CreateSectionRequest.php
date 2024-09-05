<?php

namespace App\Modules\CBT\Requests;

use App\Modules\CBT\Models\QuestionModel;
use App\Http\Requests\BaseRequest;

class CreateSectionRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'questionBankId'    => 'required|exists:question_banks,uuid',
            'title'             => 'required|string',
            'questionType'      => 'required|string|in:'.implode(',', QuestionModel::QUESTION_TYPES),
            'description'       => 'required|string',
            'totalQuestions'    => 'nullable|string',
            'sectionScore'      => 'nullable|string',
        ];
    }
}
