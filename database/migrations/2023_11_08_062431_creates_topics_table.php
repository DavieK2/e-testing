<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('topics', function(Blueprint $table){
            $table->id();
            $table->ulid('uuid');
            $table->foreignId('subject_id')->constrained();
            $table->foreignId('class_id')->constrained();
            $table->string('title');
            $table->boolean('is_synced')->default(false);
            $table->timestamps();

        });
    }

    public function down()
    {
        //
    }
};
