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
        Schema::create('temp_pallet', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_pallet');
            $table->foreign('id_pallet')->references('id')->on('pallet')->onDelete('restrict');
            $table->uuid('id_pallet_code');
            $table->foreign('id_pallet_code')->references('id')->on('pallet_code')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_pallet');
    }
};
