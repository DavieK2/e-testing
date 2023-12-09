<?php

namespace App\Modules\CBT\Requests;

use App\Modules\CBT\Models\QuestionModel;
use Illuminate\Foundation\Http\FormRequest;

class CreateSectionRequest extends FormRequest
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
            'description'       => 'required|string'
        ];
    }
}
