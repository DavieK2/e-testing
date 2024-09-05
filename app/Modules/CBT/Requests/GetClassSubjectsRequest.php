<?php

namespace App\Modules\CBT\Requests;

use App\Http\Requests\BaseRequest;

class GetClassSubjectsRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'classes'   =>      'required|array',
            'classes.*' =>      'required|exists:classes,uuid',
        ];
    }
}
