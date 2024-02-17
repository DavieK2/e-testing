<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up()
    {
        Schema::create('class_questions', function(Blueprint $table){
            $table->ulid('uuid')->unique()->index();
            $table->foreignUlid('class_id')->constrained( table: 'classes', column: 'uuid' );
            $table->foreignUlid('question_id')->constrained( table: 'questions', column: 'uuid' );
        });
    }

  
    public function down()
    {
        //
    }
};
