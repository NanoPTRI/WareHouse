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
        Schema::create('pallet_custom', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('id_inventori')->index();
            $table->integer('qty');
            $table->uuid('id_pallet')->nullable();
            $table->foreign('id_pallet')->references('id')->on('pallet')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pallet_custom');
    }
};
