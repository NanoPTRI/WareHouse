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
        Schema::create('data_pengiriman', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('tanggal_pengiriman');
            $table->string('tujuan',100);
            $table->string('expedisi',100)->nullable();
            $table->string('supir',100)->nullable();
            $table->char('no_mobil',10)->nullable();
            $table->char('no_loading',8)->nullable();
            $table->string('no_cont',100)->nullable();
            $table->time('mulai')->nullable();
            $table->time('sampai')->nullable();
            $table->dateTime('checker1')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_pengiriman');
    }
};
