<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up()
    {
        Schema::create('question_banks', function(Blueprint $table){
            $table->id();
            $table->ulid('uuid')->unique();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('assessment_id')->constrained();
            $table->foreignId('subject_id')->constrained();
            $table->json('classes')->nullable();
            $table->json('section_ids')->nullable();
            $table->boolean('is_synced')->default(false);
            $table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('question_banks');
    }
};
