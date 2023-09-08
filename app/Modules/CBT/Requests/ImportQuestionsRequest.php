<?php

namespace App\Modules\CBT\Requests;

use App\Modules\CBT\Models\AssessmentModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;

class ImportQuestionsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'file'                       => 'prohibited_unless:key,null|required_without:key|mimes:csv,xlsx,xls',
            'assessmentId'              => 'required|exists:assessments,uuid',
            'subjectId'                 => [ Rule::requiredIf(function(){

                                                $assessment = AssessmentModel::firstWhere('uuid', request('assessmentId') );

                                                if( ! $assessment->is_standalone && is_null( request('subjectId') ) && is_null( request('file') ) ){
                                                    return true;
                                                }
                                            }) 
                                        ],
            'classId'                   => [ Rule::requiredIf(function(){

                                                $assessment = AssessmentModel::firstWhere('uuid', request('assessmentId') );

                                                if( ! $assessment->is_standalone && is_null( request('classId') ) && is_null( request('file') ) ){
                                                    return true;
                                                }
                                            })
                                        ],
            'key'                       => ['prohibited_unless:file,null','required_without:file','string', function($attr, $value, $fail){
                
                                            if( is_null( Cache::get($value) ) ){
                                                $fail("Import file not found. Please reupload");
                                                return false;
                                            }
                    
                                            }],
            'mappings'                  =>  'required_without:file|array',
            'mappings.question'         =>  'required_without:file|string',
            'mappings.options'          =>  ['required_without:file', 'array', function($attr, $value, $fail){
                
                                                if(  count($value) < 2 ){
                                                    $fail("Must have more than one options");
                                                    return false;
                                                }
                    
                                            }],
            'mappings.questionScore'    =>  'string',
            'mappings.correctAnswer'    =>  'required_without:file|string',
        ];
    }
}
