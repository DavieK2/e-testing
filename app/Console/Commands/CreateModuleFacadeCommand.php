<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateModuleFacadeCommand extends BaseModuleCommand
{
    protected $signature = 'module:facade { className : Class name } { --module=* : Module }';
    
    protected $description = 'Creates a facade class for modules';
    
    protected $rootNameSpace = 'App\\';
    protected $type = 'facade';
    protected $path = '/Facades';

    public function handle()
    {
        $this->setUp();
        return Command::SUCCESS;
    }
}
