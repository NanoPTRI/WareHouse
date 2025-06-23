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
        Schema::create('pallet', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('id_inventori')->nullable()->index();
            $table->uuid('id_data_pengiriman');
            $table->foreign('id_data_pengiriman')->references('id')->on('data_pengiriman')->onDelete('restrict');

            $table->dateTime('checker2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pallet');
    }
};
