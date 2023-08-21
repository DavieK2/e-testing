<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateModuleRequestCommand extends BaseModuleCommand
{
    protected $signature = 'module:request { className : Class name } { --module=* : Module }';
    
    protected $description = 'Creates a request class for modules';
    
    protected $rootNameSpace = 'App\\';
    protected $type = 'request';
    protected $path = '/Requests';

    public function handle()
    {
        $this->setUp();
        return Command::SUCCESS;
    }
}
