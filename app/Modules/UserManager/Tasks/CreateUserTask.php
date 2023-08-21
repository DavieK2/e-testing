<?php

namespace App\Modules\UserManager\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\UserManager\Models\RoleModel;
use App\Modules\UserManager\Models\UserModel;
use Illuminate\Support\Facades\Hash;

class CreateUserTask extends BaseTasks{

    public function createUser()
    {
        $user = UserModel::create([
            'fullname' => $this->item['name'],
            'email' => $this->item['email'],
            'password' => Hash::make($this->item['password']),
            'role_id' => RoleModel::firstWhere('role_name', $this->item['role']),
        ]);

        return new static([...$this->item, 'user' => $user ]);
    }
    
}