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
            $table->string('quiz_taker_type')->nullable();
            $table->string('contributor_type')->nullable();
            $table->boolean('should_display_results')->default(false);
            $table->boolean('grade_with_assessment_type_max_score')->default(true);
            $table->boolean('should_shuffle_questions')->default(false);
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
