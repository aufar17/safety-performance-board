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
        Schema::create('agc_levels', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->string('color');
            $table->float('fr_min')->nullable();
            $table->float('fr_max')->nullable();
            $table->float('sr_min')->nullable();
            $table->float('sr_max')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agc_levels');
    }
};
