<?php

namespace App\Modules\DatabaseSyncManager\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\DatabaseSyncManager\Models\DBSyncModel;
use App\Services\CSVWriter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\SimpleExcel\SimpleExcelReader;

class SyncDatabaseTasks extends BaseTasks{

    protected CSVWriter $writer;

    public function sync()
    {
        $this->writer = new CSVWriter();

        $unnecssary_tables = $this->item['filter'];

        $tables = collect(Schema::getAllTables())->filter(fn($table) => ! in_array($table->Tables_in_cbt, $unnecssary_tables))->map(fn($table) => $table->Tables_in_cbt);

        $sync_paths = collect();

        try {
           
            $tables->each(function($table) use($sync_paths){

                $table_sync_paths =  DBSyncModel::where('has_synced', false)->where('table_synced', $table)->get()->map(fn($path) => ['id' => $path->id, 'sync_path' => $path->sync_path ]);
    
                $unsynced_records = DB::table($table)->where('is_synced', false);
    
                if( $unsynced_records->count() > 0 ){
                    
                    DB::table($table)->where('is_synced', false)->cursor()->each(function($record) use($table){
                        
                        $records = (array) $record;
                        
                        $headers = array_keys($records);
                        
                        $records = collect($records)->map(fn($value) => is_array($value) ? serialize($value) : $value )->toArray();
                        
                        
                        $this->writer->writeToCSV( $records, "/syncs/$table/", $headers );  
                    });
                    
                    $this->writer->close();
                    // $unsynced_records->update(['is_synced' => true]);
                    
                    $question_sync = DBSyncModel::create(['table_synced' => $table, 'sync_path' => $this->writer->getFilePath(), 'last_synced_date' => now()->toDateTimeString() ]);
                    
                    $table_sync_paths->push(['sync_path' => $question_sync->sync_path, 'id' => $question_sync->id ]);
                    
                }  
                
                
                $sync_paths[$table] = $table_sync_paths;
                
            });
            
          

            return $sync_paths;

        } catch (\Throwable $th) {

            $this->writer->close();
        }
    }

    public function save($path, $table)
    {
        Schema::disableForeignKeyConstraints();

        SimpleExcelReader::create($path)->getRows()->each(function($row) use($table){

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
           
            DB::table($table)->updateOrInsert( $updateColumn , $row);  
            
        });

        Schema::enableForeignKeyConstraints();

    }
    
}