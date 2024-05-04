<?php

namespace App\Modules\CBT\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetClassSubjectsRequest extends FormRequest
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
