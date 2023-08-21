<?php

namespace App\Modules\UserManager\Resources;

use App\Http\Resources\BaseResource;

class UserManagerJsonResource extends BaseResource
{
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
