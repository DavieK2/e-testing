<?php

namespace App\Console\Commands;

class CreateModuleCommand extends BaseModuleCommand
{
    protected $moduleName;

    protected $signature = 'make:module { moduleName }';

    protected $description = 'Command description';

    protected $file;

    protected $directories = [
        'Controllers',
        'Features',
        'Models',
        'Requests',
        'Resources',
        'Tasks',
        'Jobs'
    ];

    public function handle()
    {
        $this->getParameters();

        $this->makeModuleDirectories();   
    }

    protected function getParameters()
    {
        $this->moduleName = ucfirst($this->argument('moduleName'));
    }

    protected function makeModuleDirectories()
    {
        foreach($this->directories as $directory){
            $this->file->makeDirectory(app_path('Modules/'.$this->moduleName.'/'.$directory.'/'), recursive: true );
        } 
    }
}
