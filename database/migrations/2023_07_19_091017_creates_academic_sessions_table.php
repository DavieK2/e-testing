<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('academic_sessions', function(Blueprint $table){
            $table->ulid('uuid')->unique()->index();
            $table->string('session');
            $table->boolean('is_active')->default(false);
            $table->boolean('is_synced')->default(false);
            $table->timestamps();
       });
    }

    public function down()
    {
        Schema::dropIfExists('academic_sessions');
    }
};
