<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up()
    {
        Schema::create('assessment_questions', function(Blueprint $table){
            $table->id();
            $table->foreignId('assessment_id')->constrained();
            $table->foreignId('question_id')->constrained();
            $table->foreignId('subject_id')->nullable()->constrained();
            $table->foreignId('class_id')->nullable()->constrained();
            $table->boolean('is_synced')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('assessment_questions');
    }
};
