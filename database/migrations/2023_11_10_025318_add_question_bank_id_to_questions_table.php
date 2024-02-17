<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->foreignUlid('question_bank_id')->after('topic_id')->nullable()->constrained( table: 'question_banks', column: 'uuid' )->onDelete('set null');
            $table->foreignUlid('section_id')->after('topic_id')->nullable()->constrained( table: 'sections', column: 'uuid' )->onDelete('set null');
        });
    }

    
    public function down()
    {
        //
    }
};
