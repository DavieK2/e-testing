<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if( ! Schema::hasColumn('sections', 'total_questions') ){

            Schema::table('sections', function(Blueprint $table){
                $table->integer('total_questions')->nullable();
            });
        }

        if( !  Schema::hasColumn('sections', 'section_score') ) {

            Schema::table('sections', function(Blueprint $table){
               $table->double('section_score')->nullable();
            });
        }
    }

    public function down()
    {
        //
    }
};
