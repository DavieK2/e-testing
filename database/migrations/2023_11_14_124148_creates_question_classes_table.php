<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up()
    {
        Schema::create('class_questions', function(Blueprint $table){
            $table->ulid('uuid');
            $table->foreignId('class_id')->constrained();
            $table->foreignId('question_id')->constrained();
        });
    }

  
    public function down()
    {
        //
    }
};
