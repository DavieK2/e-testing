<?php

namespace App\Console\Commands;

use App\Modules\UserManager\Models\RoleModel;
use App\Modules\UserManager\Models\UserModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateNewUserCommand extends Command
{
    protected $signature = 'create:user {--fullname=} { --email= } {--password=} {--phone_no=} {--role=}';
    protected $description = 'Creates a New User';

    public function handle()
    {
       $fullname = $this->option('fullname');
       $email = $this->option('email');
       $password = $this->option('password');
       $phone_no = $this->option('phone_no');
       $role = $this->option('role');

       UserModel::create([
            'fullname'  => $fullname,
            'email'     => $email,
            'password'  => Hash::make($password),
            'phone_no'  => $phone_no,
            'role_id'   => RoleModel::firstWhere('role_name', $role)->id
       ]);

       $this->info('User Successfully Created');
    }
}
