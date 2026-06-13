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
        Schema::create('transaksi_setor_detail', function (Blueprint $table) {

            $table->id();

            // Header transaksi
            $table->foreignId('transaksi_setor_id');

            // Jenis sampah
            $table->foreignId('jenis_sampah_id');

            // Berat sampah
            $table->decimal('berat', 12, 2);

            // Harga saat transaksi
            $table->decimal('harga_satuan', 15, 2);

            // Berat x Harga
            $table->decimal('subtotal', 15, 2);

            $table->timestamps();

            // Index
            $table->index('transaksi_setor_id');
            $table->index('jenis_sampah_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_setor_detail');
    }
};