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
        $sync_data = $this->tasks->start(['tables' => ['assessment_sessions', 'assessment_results'] ])->sync();

        $sync_data = $sync_data->each( fn($data, $key) => $data->each( function($value) use($key) {

            $file = fopen( public_path( $value['sync_path'] ), 'r' );

            $request = Http::attach( 'file', $file  )->post( env('APP_URL').'/api/sync-to-online', [ 'table' => $key ]);

            if( $request->ok() ){
                
                DBSyncModel::find( $value['id'] )->update(['has_synced' => true ]);
            }

            if( is_resource( $file ) ) fclose( $file ) ;

        } ) );

        $this->info('Completed');
    }
}
