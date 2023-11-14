<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('assessment_results', function(Blueprint $table){
            $table->id();
            $table->ulid('uuid')->unique();
            $table->foreignId('student_profile_id')->constrained();
            $table->foreignId('assessment_id')->constrained();
            $table->foreignId('subject_id')->nullable()->constrained();
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->integer('time_remaining')->nullable();
            $table->boolean('has_started')->default(false);     
            $table->boolean('has_submitted')->default(false);     
            $table->integer('tries')->default(5);     
            $table->double('total_score')->nullable();
            $table->boolean('is_synced')->default(false);
            $table->timestamps();
        });
    }

   
    public function down()
    {
        Schema::dropIfExists('assessment_results');
    }
};
