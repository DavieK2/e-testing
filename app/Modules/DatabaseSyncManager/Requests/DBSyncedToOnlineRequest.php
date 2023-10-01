<?php

namespace App\Modules\DatabaseSyncManager\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DBSyncedToOnlineRequest extends FormRequest
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
