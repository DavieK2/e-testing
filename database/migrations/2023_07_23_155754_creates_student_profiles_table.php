<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('student_profiles', function(Blueprint $table){
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('surname')->nullable();
            $table->string('student_code')->unique();
            $table->string('mat_no')->nullable();
            $table->string('reg_no')->nullable();
            $table->longText('profile_pic')->nullable();
            $table->foreignId('class_id')->nullable()->constrained();
            $table->foreignId('academic_session_id')->nullable()->constrained();
            $table->foreignId('faculty_id')->nullable()->constrained();
            $table->foreignId('department_id')->nullable()->constrained();
            $table->boolean('is_synced')->default(false);
            $table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('student_profiles');
    }
};
