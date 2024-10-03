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
        Schema::create('maintenance_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maintenance_plan_id');
            $table->date('scheduled_date');
            $table->string('status');
            $table->foreignId('performed_by')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('maintenance_plan_id')->references('id')->on('maintenance_plans');
            $table->foreign('performed_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_schedules');
    }
};
