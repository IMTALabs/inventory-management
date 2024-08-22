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
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->string('equipment_name');
            $table->string('equipment_type');
            $table->string('model')->nullable();
            $table->string('serial_number')->unique();
            $table->string('manufacturer')->nullable();
            $table->date('purchase_date')->nullable();
            $table->string('location')->nullable();
            $table->string('status')->default('Active');
            $table->date('warranty_period')->nullable();
            $table->date('installation_date')->nullable();
            $table->date('last_service_date')->nullable();
            $table->date('next_service_date')->nullable();
            $table->string('equipment_condition')->default('Good');
            $table->text('equipment_specifications')->nullable();
            $table->integer('usage_duration')->nullable();
            $table->string('power_requirements')->nullable();
            $table->string('network_info')->nullable();
            $table->string('software_version')->nullable();
            $table->string('hardware_version')->nullable();
            $table->decimal('purchase_price', 10, 2)->nullable();
            $table->decimal('depreciation_value', 10, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
