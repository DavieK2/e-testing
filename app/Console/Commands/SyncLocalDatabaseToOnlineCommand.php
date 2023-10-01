<?php

namespace App\Console\Commands;

use App\Modules\DatabaseSyncManager\Models\DBSyncModel;
use App\Modules\DatabaseSyncManager\Tasks\SyncDatabaseTasks;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SyncLocalDatabaseToOnlineCommand extends Command
{
    protected $signature = 'app:sync-online';
    protected $description = 'Command description';

    public function __construct(protected SyncDatabaseTasks $tasks){
        parent::__construct();
    }

    public function handle()
    {
        $sync_data = $this->tasks->start(['filter' => ['personal_access_tokens', 'password_reset_tokens', 'migrations', 'failed_jobs', 'syncs', 'student_checkins'] ])->sync();

        $sync_data = $sync_data->each( fn($data, $key) => $data->each( function($value) use($key) {

            $file = fopen( public_path($value['sync_path']), 'r' );

            $request = Http::attach( 'file', $file  )->post( env('APP_URL').'/api/sync-to-online', [ 'table' => $key ]);

            if( $request->ok() ){
                
                DBSyncModel::find( $value['id'] )->update(['has_synced' => true ]);
            }

        } ) );

        $this->info('Completed');
    }
}
