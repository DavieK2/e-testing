<?php

namespace App\Modules\SchoolManager\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\SchoolManager\Features\CreateSchoolTermFeature;
use App\Modules\SchoolManager\Features\TermListFeature;
use App\Modules\SchoolManager\Features\UpdateTermFeature;
use App\Modules\SchoolManager\Models\TermModel;
use App\Modules\SchoolManager\Requests\CreateTermRequest;
use App\Modules\SchoolManager\Requests\TermListRequest;
use App\Modules\SchoolManager\Requests\UpdateTermRequest;

class TermController extends Controller
{
    public function index(TermListRequest $request)
    {
        return $this->serve( new TermListFeature(), $request->validated() );
    }

    public function create(CreateTermRequest $request)
    {
        return $this->serve( new CreateSchoolTermFeature(), $request->validated() );
    }

    public function update(TermModel $term, UpdateTermRequest $request)
    {
        return $this->serve( new UpdateTermFeature($term), $request->validated() );
    }
}
