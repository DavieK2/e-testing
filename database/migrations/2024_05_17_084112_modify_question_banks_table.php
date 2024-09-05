<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up()
    {
        Schema::table('question_banks', function(Blueprint $table){
            $table->boolean('is_assessment_question_bank')->default(false);
        });
    }


    public function down()
    {
        //
    }
};
