<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

abstract class BaseModuleCommand extends Command
{
    protected $file;

    protected string $className;

    protected $module;

    protected string $modulePath;

    public function __construct()
    {
        $this->file = new Filesystem();
        parent::__construct();
    }

    protected function setUp()
    {
        $this->getParameters();

        if( ! $this->checkIfModuleExists($this->modulePath) ){

            $this->info('Module does not exist...');
            return false;
        };

        $this->createModuleClass($this->modulePath.$this->path, $this->type, $this->rootNameSpace);

        return Command::SUCCESS;
    }
   
    protected function getParameters()
    {
        $this->className = Str::studly($this->argument('className'));
        $this->module = $this->option('module');


        if( ! empty($this->module ) ){
            
            $this->modulePath = 'Modules/'.Str::studly($this->module[0]);
            return;
        }
    }

    protected function checkIfModuleExists(string $path)
    {
        if($this->file->exists(app_path($path))) return true;

        return false;
    }

    protected function createModuleClass($classPath, $type, $rootNamespace)
    {
        $fileOrigin = match($type){
            'feature' => base_path('stubs/feature.stub'),
            'task' => base_path('stubs/task.stub'),
            'facade' => base_path('stubs/facade.stub'),
            'controller' => base_path('stubs/controller.plain.stub'),
            'model' => base_path('stubs/model.stub'),
            'request' => base_path('stubs/request.stub'),
            'resource' => base_path('stubs/module.resource.stub'),
            'collection' => base_path('stubs/resource-collection.stub'),
            'job' => base_path('stubs/job.stub'),
            'test' => base_path('stubs/test.stub'),
            'notification' => base_path('stubs/notification.stub'),
        };

        if( ! file_exists(app_path($classPath)) ){

            mkdir( app_path($classPath), recursive: true );
        }

        $fileDestination = app_path("$classPath/".$this->className.'.php');

        $content = [
            '{{ namespace }}' => str_replace('/','\\', $rootNamespace.$classPath),
            '{{ rootNamespace }}' => $rootNamespace,
            '{{ class }}' => $this->className,
            '{{ module }}'=> Str::studly($this->module[0]),
        ];

        $fileContents = Str::replace(array_keys($content), array_values($content), $this->file->get($fileOrigin));

        $this->file->put($fileDestination, $fileContents);
   
    } 
    
}
