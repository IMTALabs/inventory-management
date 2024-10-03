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
        Schema::create('maintenance_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id');
            $table->date('maintenance_date');
            $table->foreignId('maintenance_plan_id');
            $table->foreignId('maintenance_schedule_id');
            $table->foreignId('performed_by')->nullable();
            $table->text('description')->nullable();
            $table->string('outcome')->nullable();
            $table->timestamps();

            $table->foreign('equipment_id')->references('id')->on('equipment');
            $table->foreign('maintenance_plan_id')->references('id')->on('maintenance_plans');
            $table->foreign('maintenance_schedule_id')->references('id')->on('maintenance_schedules');
            $table->foreign('performed_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_logs');
    }
};
