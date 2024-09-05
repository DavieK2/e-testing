<?php

namespace App\Modules\CBT\Requests;

use App\Http\Requests\BaseRequest;

class AssessmentListRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'filter' => 'json',
            'perPage' => 'required|integer'
        ];
    }
}
