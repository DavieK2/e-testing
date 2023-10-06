<?php

namespace App\Modules\DatabaseSyncManager\Jobs;

use App\Modules\DatabaseSyncManager\Models\DBSyncModel;
use App\Modules\DatabaseSyncManager\Tasks\SyncDatabaseTasks;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SyncLocalDBToOnlineJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected SyncDatabaseTasks $tasks;
   
    public function __construct(){

        $this->tasks = new SyncDatabaseTasks();
    }

    public function handle()
    {
        $sync_data = $this->tasks->start(['tables' => ['assessment_sessions', 'assessment_results'] ])->sync();

        $sync_data = $sync_data->each( fn($data, $key) => $data->each( function($value) use($key) {
            
            $file = fopen( public_path( $value['sync_path'] ), 'r' );

            $request = Http::attach( 'file', $file  )->post( env('APP_URL').'/api/sync-to-online', [ 'table' => $key ]);

            if( $request->ok() ){
                
                DBSyncModel::find( $value['id'] )->update(['has_synced' => true ]);
            }

            if( is_resource( $file ) ) fclose( $file ) ;

        } ) );
    }
}
