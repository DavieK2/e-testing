<?php

namespace App\Modules\CBT\Requests;

use App\Modules\CBT\Models\AssessmentModel;
use App\Modules\CBT\Models\QuestionModel;
use App\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;

class ImportQuestionsRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $question_type = request('questionType');

        return [
            'file'                       => 'prohibited_unless:key,null|required_without:key|mimes:csv,xlsx,xls',
            'assessmentId'              => 'required|exists:assessments,uuid',
            'questionBankId'            => [ Rule::requiredIf(function(){
                                                $assessment = AssessmentModel::firstWhere('uuid', request('assessmentId') );
                                                return (! $assessment->is_standalone ) && is_null( request('file') ) ;
                                            }) 
                                        , 'exists:question_banks,uuid'],
            'key'                       => ['prohibited_unless:file,null','required_without:file','string', function($attr, $value, $fail){
                
                                                if( is_null( Cache::get($value) ) ){
                                                    $fail("Import file not found. Please reupload");
                                                    return false;
                                                }
                    
                                            }],
            'questionType'              =>  'required_without:file|string',
            'mappings'                  =>  'required_without:file|array',
            'mappings.question'         =>  'required_without:file|string',
            'sectionId'                 =>  'required_without:file|string',
            'mappings.options'          =>  ['array', function($attr, $value, $fail){
                
                                                if( count($value) < 2 ){
                                                    $fail("Must have more than one options");
                                                    return false;
                                                }
                    
                                            }, Rule::requiredIf( $question_type === QuestionModel::QUESTION_TYPES[0] && is_null( request('file') ) ) ],
            'mappings.questionScore'    =>  'string',
            'mappings.correctAnswer'    =>  [ Rule::requiredIf( $question_type === QuestionModel::QUESTION_TYPES[0] && is_null( request('file') ) ),  'string' ],
        ];
    }
}
