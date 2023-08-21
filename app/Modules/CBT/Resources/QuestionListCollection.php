<?php

namespace App\Modules\CBT\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class QuestionListCollection extends ResourceCollection
{
    public $collects = QuestionListResource::class;
    
    public function toArray($request)
    {
        // dd($this->resource);
        return parent::toArray($request);
    }
}
