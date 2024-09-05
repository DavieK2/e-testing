<?php

namespace App\Modules\DatabaseSyncManager\Requests;

use App\Http\Requests\BaseRequest;

class ConfirmDBSyncedToLocalRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required|exists:syncs,id'
        ];
    }
}
