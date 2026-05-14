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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('google_id')->nullable()->unique();
            $table->string('image')->nullable();
            $table->string('password');
            $table->string('name');
            $table->string('role')->default('user');
            $table->boolean('banned')->default(false);
            $table->foreignId('school_id')->default(1)->constrained('schools');
            $table->boolean('verified')->nullable()->default(null);
            $table->boolean('aproved')->nullable()->default(null);
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
