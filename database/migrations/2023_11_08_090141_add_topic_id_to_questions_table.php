<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->foreignUlid('topic_id')->after('subject_id')->nullable()->constrained( table: 'topics', column: 'uuid' )->onDelete('set null');
        });
    }

    public function down()
    {
       //
    }
};
