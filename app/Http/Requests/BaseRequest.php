<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

abstract class BaseRequest extends FormRequest
{
    // public function all($keys = null)
    // {
    //     return request()->method === 'GET' ? request()->query() : request()->post() + request()->file();
    // }

    protected function failedValidation(Validator $validator)
    {
        throw ( new ValidationException( $validator, 
                                         response()->json( ['errors' =>  $validator->errors()], status: 422 ) 
                                        )) ;
    }
}
