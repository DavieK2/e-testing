<?php

namespace App\Modules\SchoolManager\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTeacherRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'      =>  'required',
            'email'      =>  'required|email',
            'phoneNumber'     =>  'required'
        ];
    }
}
