<?php

namespace App\Modules\CBT\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\CBT\Models\AssessmentModel;
use App\Modules\CBT\Resources\AssessmentSubjectsCollection;
use App\Modules\CBT\Tasks\GetAssessmentSubjectsTasks;

class AssessmentResultController extends Controller
{
    public function subjects(AssessmentModel $assessment)
    {
        $assessmentSubjects = (new GetAssessmentSubjectsTasks())->start(['assessment' => $assessment])->getSubjects()->all()->item;

        return new AssessmentSubjectsCollection($assessmentSubjects);
    }
}
