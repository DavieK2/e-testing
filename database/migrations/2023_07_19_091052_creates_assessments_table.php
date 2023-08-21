<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('assessments', function(Blueprint $table){
            $table->id();
            $table->string('uuid')->unique();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->boolean('is_standalone')->default(false);
            $table->boolean('is_published')->default(false);
            $table->foreignId('assessment_type_id')->constrained();
            $table->foreignId('academic_session_id')->nullable()->constrained();
            $table->foreignId('school_term_id')->nullable()->constrained();
            $table->integer('assessment_duration')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->boolean('is_synced')->default(false);
            $table->timestamps();
       });
    }

    public function down()
    {
        Schema::dropIfExists('assessments');
    }
};
