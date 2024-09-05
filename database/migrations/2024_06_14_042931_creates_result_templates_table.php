<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('result_templates', function(Blueprint $table){
            $table->ulid('uuid');
            $table->string('title');
            $table->json('template');
            $table->double('total_score')->nullable();
            $table->double('calculate_total_score_to')->nullable();
            $table->boolean('is_synced')->default(false);
            $table->timestamps();

        });
    }

    public function down()
    {
        //
    }
};
