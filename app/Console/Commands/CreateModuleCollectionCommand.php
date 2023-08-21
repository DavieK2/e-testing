<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateModuleCollectionCommand extends BaseModuleCommand
{
    protected $signature = 'module:collection { className : Class name } { --module=* : Module }';
    
    protected $description = 'Creates an api collection class for modules';
    
    protected $rootNameSpace = 'App\\';
    protected $type = 'collection';
    protected $path = '/Resources';

    public function handle()
    {
        $this->setUp();
        return Command::SUCCESS;
    }
}
