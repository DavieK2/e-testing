<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
       Schema::create('assessment_types', function(Blueprint $table){
            $table->id();
            $table->ulid('uuid')->unique();
            $table->string('type');
            $table->integer('max_score');
            $table->boolean('is_synced')->default(false);
            $table->timestamps();
       });
    }

    public function down()
    {
        Schema::dropIfExists('assessment_types');
    }
};
