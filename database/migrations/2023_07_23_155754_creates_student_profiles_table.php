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
            $table->string('fullname');
            $table->string('student_code')->unique();
            $table->string('mat_no')->nullable();
            $table->string('reg_no')->nullable();
            $table->foreignId('class_id')->constrained();
            $table->foreignId('faculty_id')->constrained();
            $table->foreignId('department_id')->constrained();
            $table->boolean('is_synced')->default(false);
            $table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('student_profiles');
    }
};
