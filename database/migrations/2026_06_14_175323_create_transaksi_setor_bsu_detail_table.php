<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi_setor_bsu_detail', function (Blueprint $table) {

            $table->id();

            // header
            $table->foreignId('transaksi_setor_bsu_id');

            // jenis sampah
            $table->foreignId('jenis_sampah_id');

            // transaksi
            $table->decimal('berat', 12, 2);

            $table->decimal('harga_satuan', 15, 2);

            $table->decimal('subtotal', 15, 2);

            $table->timestamps();

            $table->index('transaksi_setor_bsu_id');
            $table->index('jenis_sampah_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_setor_bsu_detail');
    }
};