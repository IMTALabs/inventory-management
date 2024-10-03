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
        Schema::create('performance_metrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id');
            $table->foreignId('metric_id');
            $table->float('metric_value', 2)->nullable();
            $table->timestamps();

            $table->foreign('equipment_id')->references('id')->on('equipment');
            $table->foreign('metric_id')->references('id')->on('metrics');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_metrics');
    }
};
