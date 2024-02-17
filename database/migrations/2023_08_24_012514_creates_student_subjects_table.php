<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('student_subjects', function(Blueprint $table){
            $table->ulid('uuid')->unique()->index();
            $table->foreignUlid('student_profile_id')->constrained(table: 'student_profiles', column: 'uuid' );
            $table->foreignUlid('subject_id')->constrained( table: 'subjects', column: 'uuid' );
            $table->boolean('is_synced')->default(false);
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('student_subjects');
    }
};
