<?php

namespace App\Modules\DatabaseSyncManager\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\PendingBatch;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessSyncOnlineDBToLocalJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
 

   
    public function __construct(protected string $table, protected array $response){}

    
    public function handle()
    {
       
        $path = "sync_dl/$this->table";
    
        if( ! file_exists( public_path($path) ) ){
                    
            mkdir( public_path($path), recursive: true );
        }

        $outputPath = public_path("$path/$this->table".'_'.now()->format('Y_m_d_H_i_s').".csv");

        $jobs = [];
                
        foreach ($this->response as $data) {
            
            $jobs[] = new DownloadOnlineDBToLocalJob( $this->table, $outputPath, $data['sync_path'], $data['id'] );
  
        }

        $this->batch()->add($jobs);

    }
}
