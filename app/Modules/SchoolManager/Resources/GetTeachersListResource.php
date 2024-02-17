<?php

namespace App\Modules\SchoolManager\Resources;

use App\Http\Resources\BaseResource;

class GetTeachersListResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->uuid,
            'name' => $this->fullname,
            'email' => $this->email,
            'phoneNumber' => $this->phone_no,
        ];
    }
}
