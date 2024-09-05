<?php

namespace App\Modules\CBT\Requests;

use App\Http\Requests\BaseRequest;

class QuestionBankRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'subjectId'    =>  ['exists:subjects,uuid'],
            'classId'      =>  ['exists:classes,class_code'],
            'assessmentId' =>  'exists:assessments,uuid',
            'filter'        =>  'json',
            'perPage'      =>  'required|int',
        ];
    }
}
