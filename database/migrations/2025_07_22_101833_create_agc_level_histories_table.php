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
        Schema::create('agc_level_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('agc_level_id');
            $table->integer('total_accident');
            $table->unsignedBigInteger('work_hours');
            $table->integer('loss_day');
            $table->float('fr');
            $table->float('sr');
            $table->double('accident_hours_non_lti');
            $table->integer('man_power');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agc_level_histories');
    }
};
