<?php

namespace App\Modules\DatabaseSyncManager\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\DatabaseSyncManager\Requests\DBSyncedToOnlineRequest;
use App\Modules\DatabaseSyncManager\Tasks\SyncDatabaseTasks;
use Illuminate\Support\Facades\Storage;

class SyncLocalDatabaseToOnlineController extends Controller
{
    public function __construct(protected SyncDatabaseTasks $tasks){}

    public function sync(DBSyncedToOnlineRequest $request)
    {
        $data = $request->validated();

        $table = $data['table'];
        $file = $data['file'];

        $path = Storage::disk('local')->putFile("syncs/$table", $file);

        $this->tasks->save( storage_path("app/$path"), $table );

        return response()->json(['message' => 'Success' ]);
    }
}
