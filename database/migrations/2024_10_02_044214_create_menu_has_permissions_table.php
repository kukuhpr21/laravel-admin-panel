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
        Schema::create('menu_has_permissions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedBigInteger('menu_id')->nullable(false);
            $table->string('permission_id', 50)->nullable(false);
            $table->primary(['menu_id', 'permission_id']);
            $table->foreign('menu_id')->on('menus')->references('id')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('permission_id')->on('permissions')->references('id')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_has_permissions');
    }
};
