<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

abstract class BaseResource extends JsonResource
{
    public function __construct($resource, protected int $status = 200)
    {
        JsonResource::withoutWrapping();
        parent::__construct($resource);
    }

    public function withResponse($request, $response)
    {
         $response->setStatusCode($this->status);
    }
}
