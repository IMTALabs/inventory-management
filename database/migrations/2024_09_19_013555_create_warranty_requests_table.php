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
        Schema::create('warranty_requests', function (Blueprint $table) {
            $table->id();
            $table->date('request_date')->comment('Date the warranty request was made');
            $table->string('issue_description')->comment('Description of the issue');
            $table->string('status')->default('pending')->comment('Status of the warranty request');
            $table->foreignId('equipment_id');
            $table->foreignId('warranty_information_id');
            $table->foreignId('created_by');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('equipment_id')->references('id')->on('equipment');
            $table->foreign('warranty_information_id')->references('id')->on('warranty_information');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warranty_requests');
    }
};
