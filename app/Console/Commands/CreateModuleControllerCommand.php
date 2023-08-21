<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateModuleControllerCommand extends BaseModuleCommand
{
    protected $signature = 'module:controller { className : Class name } { --module=* : Module }';
    
    protected $description = 'Creates a controller class for modules';
    
    protected $rootNameSpace = 'App\\';
    protected $type = 'controller';
    protected $path = '/Controllers';

    public function handle()
    {
        $this->setUp();
        return Command::SUCCESS;
    }
    
}
