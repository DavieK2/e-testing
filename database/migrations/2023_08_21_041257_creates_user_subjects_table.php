<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_subjects', function(Blueprint $table) {
            $table->ulid('uuid')->unique()->index();
            $table->foreignUlid('user_id')->constrained( table: 'users', column: 'uuid' ); 
            $table->foreignUlid('subject_id')->constrained( table: 'subjects', column: 'uuid' ); 
            $table->boolean('is_synced')->default(false);
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_subjects');
    }
};
