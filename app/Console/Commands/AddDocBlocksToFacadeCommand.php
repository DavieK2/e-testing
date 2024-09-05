<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AddDocBlocksToFacadeCommand extends Command
{
    protected $signature = 'module:facade-autodoc';
    protected $description = 'Command description';

    public function handle() : int
    {
        $modules = scandir( base_path('app/Modules') );

        unset($modules[0]);
        unset($modules[1]);
    
        $files = [];
    
        foreach ($modules as $module) {
           
            $file = "app/Modules/$module/Facades";
                    
            if( ! file_exists( base_path("app/Modules/$module/Facades") ) ) continue;
            
            $files[] = $file;
      
        }

        return $this->call('autodoc:facades', [
            'paths' => $files
        ]);


    }
}
