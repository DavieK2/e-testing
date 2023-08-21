<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('assessment_classes', function(Blueprint $table){
            $table->string('assessment_id');
            $table->string('class_id');
            $table->boolean('is_synced')->default(false);
        });
    }

    public function down()
    {
        Schema::dropIfExists('assessment_classes');
    }
};
