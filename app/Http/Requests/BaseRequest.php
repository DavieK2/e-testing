<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRequest extends FormRequest
{
    public function all($keys = null)
    {
        return request()->method === 'GET' ? request()->query() : request()->post() + request()->file();
    }
}
