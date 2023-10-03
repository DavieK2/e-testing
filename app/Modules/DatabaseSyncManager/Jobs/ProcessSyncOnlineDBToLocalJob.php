<?php

namespace App\Modules\DatabaseSyncManager\Jobs;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Schema;
use Spatie\SimpleExcel\SimpleExcelReader;

class ProcessSyncOnlineDBToLocalJob
{
    use Dispatchable;

   
    public function __construct(protected string $table, protected array $response){}

    
    public function handle()
    {
       
        $path = "sync_dl/$this->table";
    
        if( ! file_exists( public_path($path) ) ){
                    
            mkdir( public_path($path), recursive: true );
        }

        $outputPath = public_path("$path/$this->table".'_'.now()->format('Y_m_d_H_i_s').".csv");

        foreach ($this->response as $data) {
        
            $output = Process::run("curl -o $outputPath ".$data['sync_path'] );

            if( $output->successful() ){

                Schema::disableForeignKeyConstraints();

                SimpleExcelReader::create($outputPath)->getRows()->each(function($row){

                    $row = collect($row)->map(function($value) {

                        $value = @unserialize($value) ? unserialize($value) : $value;

                        if( is_array($value) ){
                            $value = json_encode($value);
                        }

                        $value = $value == "" ? null : $value;

                        return $value;

                    })->toArray();

                    $row['is_synced'] = true;

                    if( ! DB::table($this->table)->where('uuid', $row['uuid'] )->first() ){

                        DB::table($this->table)->insert($row);  
                    }
                    
                });
                
                $request = Http::post(env('APP_URL').'/api/sync-to-local-confirm', ['id' => $data['id'] ] );
                                
                Schema::enableForeignKeyConstraints();
            }
        }

    }
}
