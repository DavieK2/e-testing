<?php

namespace App\Console\Commands;

use App\Modules\DatabaseSyncManager\Jobs\SaveLocalDBDataToOnlineJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SyncDataFromFile extends Command
{
    protected $signature = 'app:sync-data-from-file';
    protected $description = 'Command description';

    public function handle()
    {
        Schema::dropIfExists('assessment_results_backup');
        
        DB::unprepared( file_get_contents( base_path('assessment_results_newest.sql') ) );

        DB::table('assessment_results_backup')->cursor()->each(function($session){

            dispatch( new SaveLocalDBDataToOnlineJob( (array) $session, 'assessment_results') );
 
        });
       
        Schema::dropIfExists('assessment_results_backup');

    }
}
