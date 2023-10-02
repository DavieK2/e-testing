<?php

namespace App\Modules\SchoolManager\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\UserManager\Models\RoleModel;
use App\Modules\UserManager\Models\UserModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateTeacherTasks extends BaseTasks{

    public function createTeacher()
    {
        $user = UserModel::create([
            'uuid'      => Str::ulid(),
            'fullname'  => $this->item['name'],
            'email'     => $this->item['email'],
            'phone_no'  => $this->item['phoneNumber'],
            'password'  => Hash::make($this->item['password'] ?? 'password'),
            'role_id'   => RoleModel::firstWhere('role_name','teacher')->id
        ]);

        return new static( [ ...$this->item, 'user' => $user ] );
    }
    
}