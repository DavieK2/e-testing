<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::table('questions', function(Blueprint $table){
            $table->foreignUlid('question_id')->nullable()->constrained('questions', 'uuid')->onDelete('SET NULL');
            $table->boolean('is_generated_question')->default(false);
        });
    }

 
    public function down()
    {
        //
    }
};
