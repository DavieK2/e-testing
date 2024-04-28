<?php

namespace App\Modules\CBT\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\CBT\Features\AssignQuestionToAssessmentFeature;
use App\Modules\CBT\Features\CreateQuestionFeature;
use App\Modules\CBT\Features\ImportQuestionsFeature;
use App\Modules\CBT\Features\QuestionBankFeature;
use App\Modules\CBT\Features\QuestionListFeature;
use App\Modules\CBT\Features\UnAssignQuestionFromAssessmentFeature;
use App\Modules\CBT\Features\UpdateQuestionFeature;
use App\Modules\CBT\Models\AssessmentModel;
use App\Modules\CBT\Models\QuestionBankModel;
use App\Modules\CBT\Models\QuestionModel;
use App\Modules\CBT\Models\SectionModel;
use App\Modules\CBT\Requests\AssignQuestionToAssessmentRequest;
use App\Modules\CBT\Requests\CreateAssessmentQuestionSectionRequest;
use App\Modules\CBT\Requests\CreateQuestionRequest;
use App\Modules\CBT\Requests\DownloadQuestionsRequest;
use App\Modules\CBT\Requests\GetAssessmentQuestionSectionRequest;
use App\Modules\CBT\Requests\ImportQuestionsRequest;
use App\Modules\CBT\Requests\MassAssignQuestionsRequest;
use App\Modules\CBT\Requests\MassAssignUnQuestionsRequest;
use App\Modules\CBT\Requests\QuestionBankRequest;
use App\Modules\CBT\Requests\QuestionListRequest;
use App\Modules\CBT\Requests\UnAssignQuestionFromAssessmentRequest;
use App\Modules\CBT\Requests\UpdateQuestionRequest;
use App\Modules\Excel\Export;
use App\Modules\SchoolManager\Models\ClassModel;
use App\Services\CSVWriter;
use Maatwebsite\Excel\Facades\Excel;
use Tiptap\Editor;

class QuestionController extends Controller
{
    public function create(AssessmentModel $assessment, CreateQuestionRequest $request)
    {
        return $this->serve( new CreateQuestionFeature( $assessment ), $request->validated() );
    }

    public function update(QuestionModel $question, UpdateQuestionRequest $request)
    {
        return $this->serve( new UpdateQuestionFeature( $question ), $request->validated() );
    }

    public function import(ImportQuestionsRequest $request)
    {
        return $this->serve( new ImportQuestionsFeature(), $request->validated() );
    }

    public function getQuestions(QuestionListRequest $request)
    {
        return $this->serve( new QuestionListFeature(), $request->validated() );
    }

    public function assignQuestionToAssessment( AssessmentModel $assessment,  AssignQuestionToAssessmentRequest $request )
    {
        return $this->serve( new AssignQuestionToAssessmentFeature( $assessment ), $request->validated() );
    }

    public function unAssignQuestionFromAssessment( AssessmentModel $assessment,  UnAssignQuestionFromAssessmentRequest $request )
    {
        return $this->serve( new UnAssignQuestionFromAssessmentFeature( $assessment ), $request->validated() );
    }

    public function getQuestionBank(QuestionBankRequest $request)
    {
        return $this->serve( new QuestionBankFeature(), $request->validated() );
    }

    public function getQuestionTypes()
    {
        return response()->json([
            'data' => QuestionModel::QUESTION_TYPES
        ]);
    }

    public function massAssignQuestions(AssessmentModel $assessment, MassAssignQuestionsRequest $request)
    {
        $data = $request->validated();

        $assessment->assignQuestions( $data['questions'] , $data['subjectId'] ?? null, $data['classId'] ?? null, $data['sectionId'] ?? null );

        return response()->json([
            'message' => 'Questions Successfully Assigned'
        ]);

    }

    public function massUnassignQuestions(AssessmentModel $assessment, MassAssignUnQuestionsRequest $request)
    {
        $data = $request->validated();
                
        $assessment->unAssignQuestions( $data['questions'], $data['classId'], $data['subjectId'] );

        return response()->json([
            'message' => 'Questions Successfully Unassigned'
        ]);

    }

    public function downloadExcel(DownloadQuestionsRequest $request)
    {
        $data = $request->validated();
        
        $alphabets = collect(range('A','Z'))->flatMap( fn($alphabet) => [ $alphabet ])->toArray();
        $maxOptionsCount = 0;

        $questions = QuestionModel::whereIn('uuid', $data['questions'])->get();
        $questionData = [];

        foreach ( $questions as $index => $question ) {

            $questionContent = json_decode($question->question, true);
            $questionText = ( new Editor())->setContent($questionContent['content'])->getText();

            $options = [];
            $correctOption = '';
            
            foreach ( is_array($question->options) ? $question->options : json_decode($question->options, true) as $key => $value ) {
            
                $options[$alphabets[$key]] = $value['content'];

                if( $question->correct_answer === $value['content']) $correctOption =  $alphabets[$key];
            }

            $optionsCount = count($options);
            $maxOptionsCount = $maxOptionsCount >  $optionsCount ? $maxOptionsCount : $optionsCount;

            $questionData[] = [
                'S/N'               =>  $index + 1,
                'Question'          =>  $questionText,
                'options'           =>  $options,
                'Correct Answer'    =>  $correctOption,
                'Score'             =>  $question->question_score
            ];
         }
       
        $questionOptions =   array_slice($alphabets, 0, $maxOptionsCount );

        $headings = ['S/N','Questions', ...$questionOptions, 'Correct Answer', 'Score'];

        $newQuestionData = [];

        foreach ( $questionData as $key => $value ) {
        
            $flippedQuestionOptions = array_flip($questionOptions);

            $diff = array_diff_key($flippedQuestionOptions, $value['options']);

            $addnOptions = collect($diff)->mapWithKeys( fn( $value, $key ) => [ $key => '' ] )->toArray();

            $newQuestionData[] = [
                'S/N'               =>  $key + 1,
                'Question'          =>  $value['Question'],
                ...$value['options'] + $addnOptions,
                'Correct Answer'    =>  $value['Correct Answer'],
                'Score'             =>  $value['Score'],
            ];

            
        }

        return Excel::download( new Export( collect($newQuestionData), $headings), "questions_".now()->format('Y_m_d_H_i_s').".xlsx" );

    }
}
