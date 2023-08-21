<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateModuleJobCommand extends BaseModuleCommand
{
    protected $signature = 'module:job { className : Class name } { --module=* : Module }';
    
    protected $description = 'Creates a job class for modules';
    
    protected $rootNameSpace = 'App\\';
    protected $type = 'job';
    protected $path = '/Jobs';

    public function handle()
    {
        $this->setUp();
        return Command::SUCCESS;
    }
}
