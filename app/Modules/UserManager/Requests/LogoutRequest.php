<?php

namespace App\Modules\UserManager\Requests;

use App\Http\Requests\BaseRequest;

class LogoutRequest extends BaseRequest
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
