<?php

namespace App\Modules\CBT\Requests;

use App\Modules\CBT\Models\QuestionModel;
use Illuminate\Foundation\Http\FormRequest;

class CreateAssessmentQuestionSectionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'classId'           => 'required',
            'subjectId'         => 'required',
            'title'             => 'required|string',
            'questionType'      => 'required|string|in:'.implode(',', QuestionModel::QUESTION_TYPES),
            'description'       => 'required|string'
        ];
    }
}
