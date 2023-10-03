<?php

namespace App\Modules\DatabaseSyncManager\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\DatabaseSyncManager\Jobs\SyncOnlineDBToLocalJob;
use App\Modules\DatabaseSyncManager\Models\DBSyncModel;
use App\Modules\DatabaseSyncManager\Requests\ConfirmDBSyncedToLocalRequest;
use App\Modules\DatabaseSyncManager\Tasks\SyncDatabaseTasks;

class SyncOnlineDabataseToLocalController extends Controller
{
    public function __construct(protected SyncDatabaseTasks $tasks){}

    public function syncOnlineDatabaseToLocal()
    {
        SyncOnlineDBToLocalJob::dispatch();

        response()->json(['message' => 'Sync has started']);
    }

    public function sync()
    {        
        $sync_data = $this->tasks->start(['filter' => ['personal_access_tokens', 'password_reset_tokens', 'migrations', 'failed_jobs', 'syncs', 'student_checkins', 'assessment_results', 'assessment_sessions'] ])->sync();

        $sync_data = $sync_data->map( fn($data) => $data->map( fn($value) => [ 'id' => $value['id'], 'sync_path' => env('APP_URL').$value['sync_path']  ] ) );

        return response()->json($sync_data);

    }

    public function confirmSync(ConfirmDBSyncedToLocalRequest $request)
    {
        $data = $request->validated();

        DBSyncModel::find( $data['id'] )->update( ['has_synced' => true ]);

        return response()->json(['message' => 'Success']);
    }
}
