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
            $table->ulid('uuid')->unique();
            $table->foreignId('student_profile_id')->constrained();
            $table->foreignId('subject_id')->constrained();
            $table->json('assessments');
            $table->foreignId('academic_session_id')->nullable()->constrained();
            $table->foreignId('school_term_id')->nullable()->constrained();
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
