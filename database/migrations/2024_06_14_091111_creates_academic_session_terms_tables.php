<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('academic_session_terms', function(Blueprint $table){
            $table->ulid('uuid');
            $table->foreignUlid('academic_session_id')->constrained(table: 'academic_sessions', column: 'uuid');
            $table->foreignUlid('school_term_id')->constrained(table: 'school_terms', column: 'uuid');
            $table->json('result_templates')->nullable();
            $table->boolean('is_synced')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        //
    }
};
