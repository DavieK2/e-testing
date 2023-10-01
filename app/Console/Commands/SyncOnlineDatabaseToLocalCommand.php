<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Schema;
use Spatie\SimpleExcel\SimpleExcelReader;

class SyncOnlineDatabaseToLocalCommand extends Command
{
    protected $signature = 'app:sync';
    protected $description = 'Command description';

    public function handle()
    {
        set_time_limit(0);
        
        $request = Http::get(env('APP_URL').'/api/sync-to-local');

        $responses = $request->json();
        
        // $this->info( json_encode( $responses ));

        if( ! $request->ok() ){

            return ;
        }

       foreach( $responses as $table => $response ){

            $path = "sync_dl/$table";

            if( ! file_exists( public_path($path) ) ){
                        
                mkdir( public_path($path), recursive: true );
            }

            $outputPath = public_path("$path/$table".'_'.now()->format('Y_m_d_H_i_s').".csv");

            foreach ($response as $data) {
            
                $output = Process::run("curl -o $outputPath ".$data['sync_path'] )->errorOutput();

                $this->info($output);

                if( $output ){

                    SimpleExcelReader::create($outputPath)->getRows()->each(function($row) use($table){

                        $row = collect($row)->map(function($value) {

                            $value = @unserialize($value) ? unserialize($value) : $value;
                            $value = is_array($value) ? json_encode($value) : $value;
                            $value = $value == "" ? null : $value;

                            return $value;

                        })->toArray();

                        $row['is_synced'] = true;

                        if( isset( $row['uuid'] ) ){

                            $updateColumn = ['uuid' => $row['uuid'] ];

                        }else{

                            $updateColumn = $row;
                        }
                        
                        Schema::disableForeignKeyConstraints();
                       
                        DB::table($table)->updateOrInsert( $updateColumn , $row);  
                        
                    });

                    $request = Http::post('http://172.17.0.1/api/sync-to-local-confirm', ['id' => $data['id'] ] );
                    
                    $this->info( json_encode( $request->json() ) );
                }
            }

        }

        $this->info('completed');
    
    }
}
