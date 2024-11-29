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
        Schema::create('user_has_menus', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('user_id', 36)->nullable(false);
            $table->unsignedBigInteger('menu_id')->nullable(false);
            $table->primary(['user_id', 'menu_id']);
            $table->foreign('user_id')->on('users')->references('id')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('menu_id')->on('menus')->references('id')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_has_menus');
    }
};
