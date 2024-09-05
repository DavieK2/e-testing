<?php

namespace App\Modules\SchoolManager\Requests;

use App\Http\Requests\BaseRequest;

class ImportStudentDataFromFileRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
           'mappings'      => 'required',
           'file'           => 'mimes:zip',
           'importKey'     => 'required|string'
        ];
    }
}
