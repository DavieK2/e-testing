<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('assessment_sessions', function(Blueprint $table){
            $table->foreignId('student_profile_id')->constrained();
            $table->foreignId('assessment_id')->constrained();
            $table->foreignId('question_id')->constrained();
            $table->foreignId('subject_id')->nullable()->constrained();
            $table->string('student_answer')->nullable();
            $table->boolean('marked_for_review')->default(false);
            $table->integer('score')->default(0);
            $table->boolean('is_synced')->default(false);
            $table->timestamps();
        });
    }

   
    public function down()
    {
        Schema::dropIfExists('assessment_sessions');
    }
};
