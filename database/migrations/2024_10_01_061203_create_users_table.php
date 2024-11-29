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
            $table->engine = 'InnoDB';
            $table->uuid('id')->primary(); // Set UUID as the primary key
            $table->string('status_id', 50)->nullable(false);
            $table->string('name', 100)->nullable(false);
            $table->string('email', 100)->unique('users_email_unique');
            $table->string('password', 100);
            $table->timestamps();
            $table->foreign('status_id')->on('statuses')->references('id')->onDelete('restrict')->onUpdate('restrict');
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
