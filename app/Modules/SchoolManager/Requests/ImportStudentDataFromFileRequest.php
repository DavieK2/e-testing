<?php

namespace App\Modules\SchoolManager\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportStudentDataFromFileRequest extends FormRequest
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
