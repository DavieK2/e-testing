<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->ulid('uuid')->unique();
            $table->string('fullname');
            $table->string('email')->unique();
            $table->string('phone_no')->unique();
            $table->string('password');
            $table->boolean('has_two_factor_auth')->default(false);
            $table->string('two_factor_secret')->nullable();
            $table->timestamp('two_factor_created_at')->nullable();
            $table->timestamp('two_factor_expires_at')->nullable();
            $table->foreignId('role_id')->constrained()->default();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->boolean('is_synced')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
