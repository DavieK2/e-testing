<?php

namespace App\Modules\SchoolManager\Requests;

use App\Http\Requests\BaseRequest;

class AcademicSessionListRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            //
        ];
    }
}
