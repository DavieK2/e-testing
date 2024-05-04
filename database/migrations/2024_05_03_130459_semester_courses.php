<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
    public function up()
    {
        Schema::create('term_subjects', function(Blueprint $table){

            $table->ulid('uuid');
            $table->foreignUlid('term_id')->constrained('school_terms', 'uuid');
            $table->foreignUlid('subject_id')->constrained('subjects', 'uuid');

        });
    }

  
    public function down()
    {
        //
    }
};
