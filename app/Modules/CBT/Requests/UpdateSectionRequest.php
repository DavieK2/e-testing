<?php

namespace App\Modules\CBT\Requests;

use App\Modules\CBT\Models\QuestionModel;
use App\Http\Requests\BaseRequest;

class UpdateSectionRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'sectionTitle'          => 'required',
            'questionType'          => 'required|string|in:'.implode(',', QuestionModel::QUESTION_TYPES),
            'sectionDescription'    => 'required',
            'totalQuestions'        => 'nullable|string',
            'sectionScore'          => 'nullable|string',
        ];
    }
}
