<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CreateModuleTaskCommand extends BaseModuleCommand
{
    protected $signature = 'module:task { className : Class name } { --module=* : Module }';
    
    protected $description = 'Creates a task class for modules';
    
    protected $rootNameSpace = 'App\\';
    protected $type = 'task';
    protected $path = '/Tasks';

    public function handle()
    {
        $this->setUp();

        Artisan::call("module:facade {$this->argument('className')} --module={$this->option('module')[0]}");

        return Command::SUCCESS;
    }
}
