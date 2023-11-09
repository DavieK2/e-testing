<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('roles', function(Blueprint $table){
            $table->id();
            $table->ulid('uuid');
            $table->string('role_name')->unique();
            $table->boolean('is_synced')->default(false);
            $table->timestamps();
        });
    }

   
    public function down()
    {
        Schema::dropIfExists('roles');
    }
};
