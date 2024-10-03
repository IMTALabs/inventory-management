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
        Schema::create('warranty_logs', function (Blueprint $table) {
            $table->id();
            $table->date('log_date')->comment('Date the log was made');
            $table->string('status')->comment('Status of the warranty log');
            $table->foreignId('warranty_request_id');
            $table->foreignId('updated_by');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('warranty_request_id')->references('id')->on('warranty_requests');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warranty_logs');
    }
};
