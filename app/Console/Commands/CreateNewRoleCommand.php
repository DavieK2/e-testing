<?php

namespace App\Console\Commands;

use App\Modules\UserManager\Models\RoleModel;
use Illuminate\Console\Command;

class CreateNewRoleCommand extends Command
{
    protected $signature = 'create:role {--role=}';
    protected $description = 'Command to create new role';

    public function handle()
    {
       RoleModel::create(['role_name' => $this->option('role')]);

       $this->info('Role Successfully Created');
    }
}
