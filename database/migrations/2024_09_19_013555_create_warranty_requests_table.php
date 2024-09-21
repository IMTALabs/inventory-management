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
            $table->bigInteger('equipment_id');
            $table->bigInteger('warranty_information_id');
            $table->softDeletes();
            $table->timestamps();
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
