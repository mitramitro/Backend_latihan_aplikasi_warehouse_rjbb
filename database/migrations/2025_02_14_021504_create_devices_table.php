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
        Schema::create('devices', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('device_name');
            $table->string('brand_and_type');
            $table->string('serial_number');
            $table->string('device_type');
            $table->string('ip_address');
            $table->string('tag_name');
            $table->string('location');
            $table->foreignId('contract_id');
            $table->string('installation_year');
            $table->text('description');
            $table->foreignId('user_responsible');
            $table->foreignId('user_device');
            $table->string('condition');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
