<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateModuleFeatureCommand extends BaseModuleCommand
{
    protected $signature = 'module:feature { className : Class name } { --module=* : Module }';
    
    protected $description = 'Creates a feature class for modules';
    
    protected $rootNameSpace = 'App\\';
    protected $type = 'feature';
    protected $path = '/Features';

    public function handle()
    {
        $this->setUp();
        return Command::SUCCESS;
    }
}
