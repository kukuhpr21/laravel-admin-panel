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
        Schema::create('sessions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('user_id', 36)->nullable(false);
            $table->string('ip_address', 45)->nullable();
            $table->enum('type', ['refresh_token', 'other'])->default('other');
            $table->longText('data')->nullable(false);
            $table->string('user_agent', 100)->nullable(false);
            $table->foreign('user_id')->on('users')->references('id')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
