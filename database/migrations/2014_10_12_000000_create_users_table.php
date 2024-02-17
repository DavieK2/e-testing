<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('users', function (Blueprint $table) {
            $table->ulid('uuid')->unique()->index();
            $table->string('fullname');
            $table->string('email')->unique();
            $table->string('phone_no')->unique();
            $table->string('password');
            $table->boolean('has_two_factor_auth')->default(false);
            $table->string('two_factor_secret')->nullable();
            $table->timestamp('two_factor_created_at')->nullable();
            $table->timestamp('two_factor_expires_at')->nullable();
            $table->foreignUlid('role_id')->constrained('roles', 'uuid')->default();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->boolean('is_synced')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

// php artisan migrate:fresh --seed