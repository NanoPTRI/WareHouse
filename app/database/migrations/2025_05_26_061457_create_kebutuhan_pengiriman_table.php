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
        Schema::create('kebutuhan_pengiriman', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_data_pengiriman');
            $table->foreign('id_data_pengiriman')->references('id')->on('data_pengiriman')->onDelete('restrict');
            $table->string('id_inventori')->index();
            $table->integer('qty');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kebutuhan_pengiriman');
    }
};
