<?php

namespace App\Modules\CBT\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class QuestionBankCollection extends ResourceCollection
{
    public $collects = QuestionBankResource::class;

    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
