<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if( Schema::hasColumn('questions', 'deleted_at') ) return ;

        Schema::table('questions', function (Blueprint $table) {
           
            $table->timestamp('deleted_at')->nullable();
            
        });
    }

    public function down()
    {
        //
    }
};
