<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Modules\UserManager\Models\RoleModel;
use App\Modules\UserManager\Models\UserModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $role1 = RoleModel::create([
            'uuid'      => Str::ulid(),
            'role_name' => 'teacher'
        ]);

        $role2 = RoleModel::create([
            'uuid'      => Str::ulid(),
            'role_name' => 'student'
        ]);

        $role3 = RoleModel::create([
            'uuid'      => Str::ulid(),
            'role_name' => 'admin'
        ]);

        UserModel::create([
            'uuid'      => Str::ulid(),
            'fullname'  => 'Test User',
            'email'     => 'admin@jephthah.com',
            'password'  => Hash::make('JEPHadmin1234!'),
            'phone_no'  => '2345678900000',
            'role_id'   => $role3->id
        ]);

        UserModel::create([
            'uuid'      => Str::ulid(),
            'fullname'  => 'Test Teacher',
            'email'     => 'teacher@example.com',
            'password'  => Hash::make('password'),
            'phone_no'  => '2345678900100',
            'role_id'   => $role1->id
        ]);
    }
}
