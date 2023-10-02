<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $unnecssary_tables = ['personal_access_tokens', 'password_reset_tokens', 'migrations', 'failed_jobs', 'syncs', 'student_checkins', 'questions', 'assessments'];

        $tables = collect(Schema::getAllTables())->filter(fn($table) => ! in_array($table->Tables_in_cbt, $unnecssary_tables))->map(fn($table) => $table->Tables_in_cbt);

        $tables->each(function($table){


            if( Schema::hasColumn( $table, 'uuid') ){
                

                Schema::table($table, function (Blueprint $table) {
                    $table->uuid('uuid')->change();
                });

                DB::statement("UPDATE $table SET `uuid` = UUID()");

            }else{
                
                Schema::table($table, function (Blueprint $table) {
                    $table->uuid('uuid');
                });

                DB::statement("UPDATE $table SET `uuid` = UUID()");
            }  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('table', function (Blueprint $table) {
            //
        });
    }
};
