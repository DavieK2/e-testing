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
            $table->foreignUlid('class_id')->nullable()->constrained( table: 'classes', column: 'uuid' )->onDelete('set null');
            $table->foreignUlid('question_id')->nullable()->constrained( table: 'questions', column: 'uuid' )->onDelete('set null');
        });
    }

  
    public function down()
    {
        //
    }
};
