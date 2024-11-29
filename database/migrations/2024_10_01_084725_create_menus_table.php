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
        Schema::create('menus', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('name', 100)->nullable(false);
            $table->string('link', 100)->nullable(false)->default('#');
            $table->string('link_alias', 100)->nullable(false)->default('#');
            $table->string('icon', 100)->nullable(false)->default('#');
            $table->bigInteger('parent')->nullable(false)->default(0);
            $table->bigInteger('order')->nullable(false)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
