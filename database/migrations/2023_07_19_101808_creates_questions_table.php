<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('questions', function(Blueprint $table){
            $table->id();
            $table->ulid('uuid')->unique();
            $table->longText('question');
            $table->foreignId('assessment_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->json('options');
            $table->string('correct_answer');
            $table->float('question_score');
            $table->foreignId('class_id')->nullable()->constrained();
            $table->foreignId('subject_id')->nullable()->constrained();
            $table->boolean('is_synced')->default(false);
            $table->timestamps();
       });
    }

    public function down()
    {
        Schema::dropIfExists('questions');
    }
};
