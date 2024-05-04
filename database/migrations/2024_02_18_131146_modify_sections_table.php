<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        
        Schema::table('sections', function(Blueprint $table){
           
            $table->foreignUlid('assessment_id')->nullable()->constrained( table: 'assessments', column: 'uuid' );
            $table->foreignUlid('subject_id')->nullable()->constrained( table: 'subjects', column: 'uuid' );
            $table->json('classes')->nullable();
            
        });
    }

   
    public function down()
    {
        //
    }
};
