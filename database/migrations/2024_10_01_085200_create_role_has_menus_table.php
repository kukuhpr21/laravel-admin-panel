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
        Schema::create('role_has_menus', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('role_id', 50)->nullable(false);
            $table->unsignedBigInteger('menu_id')->nullable(false);
            $table->primary(['role_id', 'menu_id']);
            $table->foreign('role_id')->on('roles')->references('id')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('menu_id')->on('menus')->references('id')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_has_menus');
    }
};
