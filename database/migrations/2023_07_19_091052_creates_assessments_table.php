<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('assessments', function(Blueprint $table){
            $table->string('uuid')->unique()->index();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->boolean('is_standalone')->default(false);
            $table->boolean('is_published')->default(false);
            $table->foreignUlid('assessment_type_id')->constrained( table: 'assessment_types', column: 'uuid' );
            $table->foreignUlid('academic_session_id')->nullable()->constrained( table: 'academic_sessions', column: 'uuid' );
            $table->foreignUlid('school_term_id')->nullable()->constrained( table: 'school_terms', column: 'uuid' );
            $table->integer('assessment_duration')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->boolean('has_generated_results')->default(false);
            $table->boolean('is_synced')->default(false);
            $table->timestamps();
       });
    }

    public function down()
    {
        Schema::dropIfExists('assessments');
    }
};
