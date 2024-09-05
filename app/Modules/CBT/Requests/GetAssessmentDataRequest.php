<?php

namespace App\Modules\CBT\Requests;

use App\Http\Requests\BaseRequest;

class GetAssessmentDataRequest extends BaseRequest
{
    public function authorize()
    {
        return false;
    }

    public function rules()
    {
        return [
            //
        ];
    }
}
