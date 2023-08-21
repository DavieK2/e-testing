<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateModuleModelCommand extends BaseModuleCommand
{
    protected $signature = 'module:model { className : Class name } { --module=* : Module }';
    
    protected $description = 'Creates a model class for modules';
    
    protected $rootNameSpace = 'App\\';
    protected $type = 'model';
    protected $path = '/Models';

    public function handle()
    {
        $this->setUp();
        return Command::SUCCESS;
    }
    
}
