<?php

namespace App\Modules\CBT\Requests;

use App\Modules\CBT\Models\QuestionModel;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSectionRequest extends FormRequest
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
        ];
    }
}
