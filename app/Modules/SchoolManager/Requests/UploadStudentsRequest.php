<?php

namespace App\Modules\SchoolManager\Requests;

use App\Http\Requests\BaseRequest;

class UploadStudentsRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'file' => 'required|mimes:csv,xlsx,txt'
        ];
    }
}
