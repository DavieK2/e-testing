<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('assessment_students', function(Blueprint $table){
            
            $table->ulid('uuid')->unique()->index();
            $table->foreignUlid('student_profile_id')->constrained( table: 'student_profiles', column: 'uuid');
            $table->foreignUlid('assessment_id')->constrained( table: 'assessments', column: 'uuid');

            $table->unique(['student_profile_id', 'assessment_id']);
            $table->boolean('is_synced')->default(false);

        });
    }

 
    public function down()
    {
        //
    }
};
