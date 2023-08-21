<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateModuleResourceCommand extends BaseModuleCommand
{
    protected $signature = 'module:resource { className : Class name } { --module=* : Module }';
    
    protected $description = 'Creates an api resource class for modules';
    
    protected $rootNameSpace = 'App\\';
    protected $type = 'resource';
    protected $path = '/Resources';

    public function handle()
    {
        $this->setUp();
        return Command::SUCCESS;
    }
}
