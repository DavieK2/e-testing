<?php

namespace App\Modules\SchoolManager\Requests;

use App\Modules\SchoolManager\Models\SubjectModel;
use App\Http\Requests\BaseRequest;

class AssignTeacherToClassSubjectRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
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
