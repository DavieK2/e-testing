<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up()
    {
        Schema::create('assessment_questions', function(Blueprint $table){
            $table->ulid('uuid')->unique()->index();
            $table->foreignUlid('assessment_id')->constrained( table: 'assessments', column: 'uuid' );
            $table->foreignUlid('question_id')->constrained( table: 'questions', column: 'uuid' );
            $table->foreignUlid('subject_id')->nullable()->constrained( table: 'subjects', column: 'uuid' );
            $table->foreignUlid('class_id')->nullable()->constrained( table: 'classes', column: 'uuid' );
            $table->foreignUlid('section_id')->nullable()->constrained( table: 'sections', column: 'uuid' );
            $table->boolean('is_synced')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('assessment_questions');
    }
};
