<?php

namespace App\Modules\SchoolManager\Requests;

use App\Modules\UserManager\Models\UserModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateTeacherRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $user = $this->route('teacher');

        return [
            'name'              =>  'required',
            'email'             =>  ['required','email', function($attr, $val, $fail) use($user) {
                                        if( $user && $user->email != $val && UserModel::where('email', $val)->exists() ) {
                                            $fail('Email had already been taken');
                                            return false;
                                        }
                                        if( ! $user && UserModel::where('email', $val)->exists() ) {
                                            $fail('Email had already been taken');
                                            return false;
                                        }
                                    }],
            'phoneNumber'       =>  'required',
            'password'          =>  'nullable|string'
        ];
    }
}
