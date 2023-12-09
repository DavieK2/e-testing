<?php

namespace App\Modules\CBT\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\CBT\Models\AssessmentModel;
use App\Modules\CBT\Models\QuestionModel;
use App\Services\CSVWriter;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\SimpleExcel\SimpleExcelReader;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Tiptap\Editor;

class ImportQuestionsTask extends BaseTasks{

    protected ?CSVWriter $errorFileWriter = NULL;

    public function saveFileToLocalDisk()
    {
        $path = 'imports/questions';
     
        $file = Storage::disk('local')->putFile($path, $this->item['file']);

        $key = Str::random(6);

        Cache::put($key, $file, now()->addMinutes(60));

        $rows = SimpleExcelReader::create(storage_path("app/".$file))->take(1)->getRows()->toArray();
        
        return new static( [ ...$this->item, 'key' => $key, 'headings' => $rows[0] ]);

    }

    public function importQuestions()
    {
        $importFileKey = Cache::get($this->item['key']);

        $errors = [];
        
        SimpleExcelReader::create( storage_path("app/$importFileKey") )->trimHeaderRow()->getRows()->each(function($row){
               
            $mapping = $this->item['mappings'];
        

            $data = collect($mapping)->flatMap(function($map, $index) use($row) {

                $options = [];

                if( is_array($map) ) {

                    foreach($map as $value){
                        $options[ trim( strtolower($value) ) ] = trim( $row[$value] );
                    }
                }

                $row = collect($row)->mapWithKeys(fn($value, $key) => [ trim( $key ) => trim( ucfirst( $value ) ) ])->toArray();

                return [
                    $index =>  is_array($map) ? $options : $row[ trim( $map ) ] 
                ];

            })->toArray();
            
            $data['correctAnswer'] = $data['options'][ strtolower( $data['correctAnswer'] ?? '' ) ] ?? null;

            $validator = Validator::make($data, [
                'question'          => 'required',
                'options'           => ['array', function($atrr, $val, $fail){

                                            if( count($val) < 2 ) {
                                                $fail("Must have at least two options");
                                                return false;
                                            }
                                        }, Rule::requiredIf( $this->item['questionType'] === QuestionModel::QUESTION_TYPES[0]  )],
                'correctAnswer'     => [function($atrr, $val, $fail) use($data) {

                                            if( isset( $data['options'] )  && ( ! in_array($val, $data['options']) ) ) {

                                                $fail($val." is not part of the options and cannot be the correct answer");
                                                return false;
                                            }
                                        }, Rule::requiredIf( $this->item['questionType'] === QuestionModel::QUESTION_TYPES[0] ) ],
                'questionScore'     => 'nullable',
            ]);

            if( $validator->fails() ){

                $this->errorFileWriter = $this->errorFileWriter ?? new CSVWriter();

                $this->errorFileWriter->writeToCSV([ ...array_values($row), implode(', ', $validator->errors()->all() ) ], 'imports/question/errors/', [ ...array_keys($row), 'errors' ] );

                return ;
            }

            $data =  $validator->validated();

            $data['options'] = collect( array_values( $data['options'] ?? [] ) )->map( fn($option) => ['type' => 'text', 'content' => $option ] )->toArray();

            $question = $data['question'];

            $content = ( new Editor())->setContent("<p>$question</p>")->getDocument();

            $question = ['type' => 'html', 'content' => $content ];

            $data['question'] = json_encode( $question );

            $data['questionType'] = $this->item['questionType'];

            $data['sectionId'] = $this->item['sectionId'] ?? null;

            $assessment = AssessmentModel::firstWhere('uuid', $this->item['assessmentId']);

            ( new CreateQuestionTasks() )->start($data + ['assessment' => $assessment, 'questionBankId' => $this->item['questionBankId'] ?? null ])->createQuestion();
            
        });


        if( $this->errorFileWriter ) {

            $this->errorFileWriter->close();

            $errors['errors'] = url( $this->errorFileWriter->getFilePath() );
        }
        
        return new static( $this->item +  $errors );
    }
    
}