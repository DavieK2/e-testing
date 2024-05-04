<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up()
    {
        Schema::create('assessment_users', function(Blueprint $table){

            $table->ulid('uuid');
            $table->foreignUlid('user_id')->nullable()->constrained('users', 'uuid')->onDelete('set null');
            $table->foreignUlid('assessment_id')->nullable()->constrained('assessments', 'uuid')->onDelete('set null');
        });
    }

   
    public function down()
    {
        Schema::dropIfExists('assessment_users');
    }
};
