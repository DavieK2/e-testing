<?php

namespace App\Modules\SchoolManager\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\CBT\Requests\GetClassSubjectsRequest;
use App\Modules\SchoolManager\Features\AssignSubjectToClassFeature;
use App\Modules\SchoolManager\Features\ClassListFeature;
use App\Modules\SchoolManager\Features\CreateClassFeature;
use App\Modules\SchoolManager\Features\GetClassSubjectsFeature;
use App\Modules\SchoolManager\Features\UpdateClassFeature;
use App\Modules\SchoolManager\Models\ClassModel;
use App\Modules\SchoolManager\Requests\AssignSubjectToClassRequest;
use App\Modules\SchoolManager\Requests\ClassListRequest;
use App\Modules\SchoolManager\Requests\CreateClassRequest;
use App\Modules\SchoolManager\Requests\UpdateClassRequest;

class ClassController extends Controller
{
    public function index(ClassListRequest $request)
    {
        return $this->serve( new ClassListFeature(), $request->validated() );
    }

    public function create(CreateClassRequest $request)
    {
        return $this->serve( new CreateClassFeature(), $request->validated() );
    }

    public function update(UpdateClassRequest $request)
    {
        return $this->serve( new UpdateClassFeature(), $request->validated() );
    }

    public function subjects(GetClassSubjectsRequest $request)
    {
        return $this->serve( new GetClassSubjectsFeature(), $request->validated() );
    }

    public function assignSubjects(AssignSubjectToClassRequest $request)
    {
        return $this->serve( new AssignSubjectToClassFeature(), $request->validated() );
    }
}
