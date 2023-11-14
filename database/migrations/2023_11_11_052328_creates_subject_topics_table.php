<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up()
    {
        Schema::create('class_topics', function(Blueprint $table){
            $table->ulid('uuid');
            $table->foreignId('topic_id')->constrained();
            $table->foreignId('class_id')->constrained();
            $table->foreignId('subject_id')->constrained();
            $table->boolean('is_synced')->default(false);
        });
    }

   
    public function down()
    {
        //
    }
};
