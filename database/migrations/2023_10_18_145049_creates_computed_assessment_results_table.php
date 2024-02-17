<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assessment_results', function (Blueprint $table) {
            $table->double('total_score')->nullable()->change();
        });

        Schema::create('computed_assessment_results', function(Blueprint $table){
            $table->ulid('uuid')->unique()->index();
            $table->foreignUlid('student_profile_id')->constrained( table: 'student_profiles', column: 'uuid' );
            $table->foreignUlid('subject_id')->constrained( table: 'subjects', column: 'uuid' );
            $table->json('assessments');
            $table->foreignUlid('academic_session_id')->nullable()->constrained( table: 'academic_sessions', column: 'uuid' );
            $table->foreignUlid('school_term_id')->nullable()->constrained( table: 'school_terms', column: 'uuid' );
            $table->double('total_score')->nullable();
            $table->string('grade');
            $table->string('remarks');
            $table->boolean('is_synced')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('computed_assessment_results');
    }
};
