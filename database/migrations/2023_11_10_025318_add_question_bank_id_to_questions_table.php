<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->foreignId('question_bank_id')->after('topic_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('section_id')->after('topic_id')->nullable()->constrained()->onDelete('set null');
        });
    }

    
    public function down()
    {
        //
    }
};
