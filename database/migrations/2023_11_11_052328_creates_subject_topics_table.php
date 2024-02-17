<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up()
    {
        Schema::create('class_topics', function(Blueprint $table){
            $table->ulid('uuid')->index();
            $table->foreignUlid('topic_id')->constrained( table: 'topics', column: 'uuid' );
            $table->foreignUlid('class_id')->constrained( table: 'classes', column: 'uuid' );
            $table->foreignUlid('subject_id')->constrained( table: 'subjects', column: 'uuid' );
            $table->boolean('is_synced')->default(false);
        });
    }

   
    public function down()
    {
        //
    }
};
