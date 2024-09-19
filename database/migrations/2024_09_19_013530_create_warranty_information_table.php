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
        Schema::create('warranty_information', function (Blueprint $table) {
            $table->id();
            $table->string('provider_name')->comment('Name of the warranty provider');
            $table->string('provider_address')->comment('Address of the warranty provider');
            $table->string('contact_info')->comment('Contact information of the warranty provider');
            $table->bigInteger('equipment_id');
            $table->date('warranty_start_date')->comment('Start date of the warranty');
            $table->date('warranty_end_date')->comment('End date of the warranty');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warranty_information');
    }
};
