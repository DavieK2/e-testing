<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up()
    {
        if( Schema::hasTable('assessment_questions') ) return ;

        
        Schema::create('assessment_questions', function(Blueprint $table){
            $table->ulid('uuid')->unique()->index();
            $table->foreignUlid('assessment_id')->nullable()->constrained( table: 'assessments', column: 'uuid' )->onDelete('set null');
            $table->foreignUlid('question_id')->nullable()->constrained( table: 'questions', column: 'uuid' )->onDelete('set null');
            $table->foreignUlid('subject_id')->nullable()->constrained( table: 'subjects', column: 'uuid' )->onDelete('set null');
            $table->foreignUlid('class_id')->nullable()->constrained( table: 'classes', column: 'uuid' )->onDelete('set null');
            $table->foreignUlid('section_id')->nullable()->constrained( table: 'sections', column: 'uuid' )->onDelete('set null');
            $table->boolean('is_synced')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('assessment_questions');
    }
};
