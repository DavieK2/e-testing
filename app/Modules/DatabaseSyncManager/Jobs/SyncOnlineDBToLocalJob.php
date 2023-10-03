<?php

namespace App\Modules\DatabaseSyncManager\Jobs;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Artisan;

class SyncOnlineDBToLocalJob
{
    use Dispatchable;

   
    public function __construct()
    {
        //
    }

    public function handle()
    {
        Artisan::call('app:sync');
    }
}
