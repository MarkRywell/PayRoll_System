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
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('address_id')->constrained('addresses')->onDelete('cascade')->onUpdate('cascade');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('contact_number');
            $table->string('position');
            $table->double('rate', 6, 2);
            $table->boolean('status');
            $table->string('photo')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
