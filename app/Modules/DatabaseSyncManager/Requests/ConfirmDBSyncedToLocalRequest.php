<?php

namespace App\Modules\DatabaseSyncManager\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmDBSyncedToLocalRequest extends FormRequest
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
