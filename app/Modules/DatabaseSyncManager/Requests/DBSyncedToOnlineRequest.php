<?php

namespace App\Modules\DatabaseSyncManager\Requests;

use App\Http\Requests\BaseRequest;

class DBSyncedToOnlineRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'table'     => 'string',
            'file'       => 'file'
        ];
    }
}
