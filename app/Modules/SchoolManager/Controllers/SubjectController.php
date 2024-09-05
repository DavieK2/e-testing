<?php

namespace App\Modules\SchoolManager\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\SchoolManager\Features\CreateSubjectFeature;
use App\Modules\SchoolManager\Features\SubjectListFeature;
use App\Modules\SchoolManager\Features\UpdateSubjectFeature;
use App\Modules\SchoolManager\Models\ClassModel;
use App\Modules\SchoolManager\Models\SubjectModel;
use App\Modules\SchoolManager\Requests\CreateSubjectRequest;
use App\Modules\SchoolManager\Requests\SubjectListRequest;
use App\Modules\SchoolManager\Requests\UpdateSubjectRequest;

class SubjectController extends Controller
{
    public function index(SubjectListRequest $request)
    {
        return $this->serve( new SubjectListFeature(), $request->validated() );
    }

    public function create(CreateSubjectRequest $request)
    {
        return $this->serve( new CreateSubjectFeature(), $request->validated() );
    }

    public function update(SubjectModel $subject, UpdateSubjectRequest $request)
    {
        return $this->serve( new UpdateSubjectFeature($subject), $request->validated() );
    }

    public function classes(ClassModel $class)
    {
        
    }
}
