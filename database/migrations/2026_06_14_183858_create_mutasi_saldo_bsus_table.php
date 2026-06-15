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
        Schema::create('mutasi_saldo_bsu', function (Blueprint $table) {

            $table->id();

            // BSU
            $table->foreignId('bsu_id');

            // Referensi transaksi
            $table->foreignId('transaksi_setor_bsu_id')
                ->nullable();

            // Jenis mutasi
            $table->string('jenis_mutasi', 20);

            // Nilai mutasi
            $table->decimal('saldo_sebelum', 15, 2);

            $table->decimal('jumlah', 15, 2);

            $table->decimal('saldo_sesudah', 15, 2);

            // Tanggal mutasi
            $table->dateTime('tanggal_mutasi');

            // Catatan
            $table->text('keterangan')
                ->nullable();

            // Audit
            $table->foreignId('created_by')
                ->nullable();

            $table->timestamps();

            // Index
            $table->index('bsu_id');

            $table->index('transaksi_setor_bsu_id');

            $table->index('jenis_mutasi');

            $table->index('tanggal_mutasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasi_saldo_bsu');
    }
};