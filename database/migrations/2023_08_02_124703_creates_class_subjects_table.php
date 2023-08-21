<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('class_subjects', function(Blueprint $table){
            $table->string('class_id');
            $table->string('subject_id');
            $table->boolean('is_synced')->default(false);
        });
    }

    public function down()
    {
        Schema::dropIfExists('class_subjects');
    }
};
