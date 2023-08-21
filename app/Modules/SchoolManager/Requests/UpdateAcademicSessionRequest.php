<?php

namespace App\Modules\SchoolManager\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAcademicSessionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'academicSessionId' => 'required|exists:academic_sessions,id',
            'session' => 'required'
        ];
    }
}
