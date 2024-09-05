<?php

namespace App\Modules\SchoolManager\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\SchoolManager\Features\AcademicSessionListFeature;
use App\Modules\SchoolManager\Features\CreateAcademicSessionFeature;
use App\Modules\SchoolManager\Features\UpdateAcademicSessionFeature;
use App\Modules\SchoolManager\Models\AcademicSessionModel;
use App\Modules\SchoolManager\Requests\AcademicSessionListRequest;
use App\Modules\SchoolManager\Requests\CreateAcademicSessionRequest;
use App\Modules\SchoolManager\Requests\UpdateAcademicSessionRequest;

class AcademicSessionController extends Controller
{
    public function index(AcademicSessionListRequest $request)
    {
        return $this->serve( new AcademicSessionListFeature(), $request->validated() );
    }

    public function create(CreateAcademicSessionRequest $request)
    {
        return $this->serve( new CreateAcademicSessionFeature(), $request->validated() );
    }

    public function update(AcademicSessionModel $academic_session, UpdateAcademicSessionRequest $request)
    {
        return $this->serve( new UpdateAcademicSessionFeature($academic_session), $request->validated() );
    }
}
