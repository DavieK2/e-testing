<?php

namespace App\Modules\SchoolManager\Resources;

use App\Http\Resources\BaseResource;

class ClassListResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'class_name'    => $this->class_name,
            'class_code'    => $this->class_code,
        ];
    }
}
