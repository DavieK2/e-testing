<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('questions', function(Blueprint $table){
            $table->ulid('uuid')->unique()->index();
            $table->longText('question');
            $table->foreignUlid('assessment_id')->nullable()->references('uuid')->on('assessments')->onDelete('SET NULL');
            $table->foreignUlid('user_id')->nullable()->references('uuid')->on('users')->onDelete('SET NULL');
            $table->json('options');
            $table->string('question_type');
            $table->string('correct_answer')->nullable();
            $table->double('question_score')->default(0);
            $table->foreignUlid('class_id')->nullable()->references('uuid')->on('classes')->onDelete('SET NULL');
            $table->foreignUlid('subject_id')->nullable()->references('uuid')->on('subjects')->onDelete('SET NULL');
            $table->boolean('is_synced')->default(false);
            $table->timestamps();
            $table->softDeletes();
       });
    }

    public function down()
    {
        Schema::dropIfExists('questions');
    }
};
