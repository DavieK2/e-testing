<?php

namespace App\Modules\CBT\Requests;

use App\Modules\SchoolManager\Models\ClassModel;
use App\Modules\SchoolManager\Models\SubjectModel;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class MassAssignQuestionsRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $assessment = $this->route('assessment');
       
        return [
            'sectionId'     => [ 'required', 'exists:sections,uuid' ],
            'questions'     => 'required|array',
            'subjectId'     => [ Rule::requiredIf( ! $assessment->is_standalone ), function($attr, $val, $fail){

                                   if( $val ) return SubjectModel::firstWhere('uuid', $val)->exists();
            }],
            'classId'       => [ Rule::requiredIf( ! $assessment->is_standalone ), function($attr, $val, $fail){
                
                                   if( $val ) return ClassModel::firstWhere('class_code', $val)->exists();
            }],
            'questions.*'   => 'exists:questions,uuid'
        ];
    }
}
