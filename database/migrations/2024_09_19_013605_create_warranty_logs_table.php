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
            $table->bigInteger('waranty_request_id');
            $table->softDeletes();
            $table->timestamps();
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
