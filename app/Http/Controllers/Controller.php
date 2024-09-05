<?php

namespace App\Http\Controllers;

use App\Contracts\FeatureContract;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function serve(FeatureContract $feature, $data = []) : JsonResource
    {
        return $feature->handle($feature->tasks, $data);
    }
}