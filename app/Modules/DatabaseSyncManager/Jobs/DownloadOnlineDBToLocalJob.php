<?php

namespace App\Modules\DatabaseSyncManager\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Process;
use Spatie\SimpleExcel\SimpleExcelReader;

class DownloadOnlineDBToLocalJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

   
    public function __construct(protected string $table, protected string $outputPath, protected string $path, protected int $sync_id) { }

    public function handle()
    {
        $sync_id = $this->sync_id;
        
        $output = Process::run("curl -o $this->outputPath ".$this->path );

        if( $output->successful() ){

            $jobs = collect();

            $batch = Bus::batch([]);
            
            SimpleExcelReader::create($this->outputPath)->getRows()->each(function($row) use($jobs){

                $jobs->push(new SaveOnlineDBToLocalJob( $row, $this->table ));
                
            });

            $batch->add($jobs->toArray())
                  ->finally(fn() => Http::post(env('APP_URL').'/api/sync-to-local-confirm', ['id' => $sync_id ] ))
                  ->dispatch();

        }
    }
}
