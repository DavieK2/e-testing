<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('assessment_classes', function(Blueprint $table){
            $table->ulid('uuid')->unique();
            $table->foreignUlid('assessment_id')->constrained( table: 'assessments',column: 'uuid');
            $table->foreignUlid('class_id')->constrained( table: 'classes',column: 'uuid');
            $table->boolean('is_synced')->default(false);
        });
    }

    public function down()
    {
        Schema::dropIfExists('assessment_classes');
    }
};
