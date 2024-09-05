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

    public function update(ClassModel $class, UpdateClassRequest $request)
    {
        return $this->serve( new UpdateClassFeature($class), $request->validated() );
    }

    public function subjects(ClassModel $class)
    {
        return $this->serve( new GetClassSubjectsFeature($class) );
    }

    public function assignSubjects(ClassModel $class, AssignSubjectToClassRequest $request)
    {
        return $this->serve( new AssignSubjectToClassFeature($class), $request->validated() );
    }
}
