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
        Schema::create('reportdevices', function (Blueprint $table) {
            $table->id();
            $table->string('device_name');
            $table->string('device_type');
            $table->string('status_used_new');
            $table->string('status_damage');
            $table->string('status_rent');
            $table->string('status_asset');
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportdevices');
    }
};
