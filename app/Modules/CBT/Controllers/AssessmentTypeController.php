<?php

namespace App\Modules\CBT\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\CBT\Features\AssessmentTypeListFeature;
use App\Modules\CBT\Features\CreateAssessmentTypeFeature;
use App\Modules\CBT\Features\UpdateAssessmentTypeFeature;
use App\Modules\CBT\Requests\AssessmentTypeListRequest;
use App\Modules\CBT\Requests\CreateAssessmentTypeRequest;
use App\Modules\CBT\Requests\UpdateAssessmentTypeRequest;

class AssessmentTypeController extends Controller
{
    public function index(AssessmentTypeListRequest $request)
    {
        return $this->serve( new AssessmentTypeListFeature(), $request->validated() );
    }

    public function create(CreateAssessmentTypeRequest $request)
    {
        return $this->serve( new CreateAssessmentTypeFeature(), $request->validated() );
    }

    public function update(UpdateAssessmentTypeRequest $request)
    {
        return $this->serve( new UpdateAssessmentTypeFeature(), $request->validated() );
    }
}
