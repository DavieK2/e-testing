<?php

namespace App\Modules\CBT\Requests;

use App\Http\Requests\BaseRequest;

class GetStudentResultRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'assessmentId'  => 'required|exists:assessments,uuid',
            'studentId'     => 'required|exists:student_profiles,uuid',
        ];
    }
}
