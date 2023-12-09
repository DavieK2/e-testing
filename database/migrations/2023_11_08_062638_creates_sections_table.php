<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up()
    {
        Schema::create('sections', function(Blueprint $table){
            $table->id();
            $table->ulid('uuid')->unique();
            $table->foreignId('question_bank_id')->constrained();
            $table->string('section_code')->unique();
            $table->string('title');
            $table->longText('description');
            $table->string('question_type');
            $table->boolean('is_synced')->default(false);
            $table->timestamps();
        });
    }

    
    public function down()
    {
        //
    }
};
