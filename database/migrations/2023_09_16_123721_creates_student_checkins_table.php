<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('student_checkins', function(Blueprint $table){
            $table->id();
            $table->foreignId('assessment_id')->constrained();
            $table->foreignId('student_profile_id')->constrained();
            $table->timestamp('checked_in_at');
            $table->timestamp('checked_in_expires_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_checkins');
    }
};
