<?php

namespace App\Modules\SchoolManager\Requests;

use App\Modules\SchoolManager\Models\SubjectModel;
use Illuminate\Foundation\Http\FormRequest;

class AssignTeacherToClassSubjectRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'teacherId'             => 'required|exists:users,id',
            'classSubjects'         => 'required|array',
            'classSubjects'         => [ function($attr, $val, $fail){
                                            $keys = array_keys($val);
                                            
                                            foreach ($keys as $value) {
                                                
                                                if( ! SubjectModel::find($value) ){

                                                    $fail('One or more invalid subject');

                                                    return false;

                                                    break;
                                                }
                                            }
                                            
                                    }],
            'classSubjects.*.*'     => 'required|exists:classes,class_code',
        ];
    }
}
