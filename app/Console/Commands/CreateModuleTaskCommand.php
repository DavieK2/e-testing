<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
        return Command::SUCCESS;
    }
}
