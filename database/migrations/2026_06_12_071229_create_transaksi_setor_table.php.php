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
        Schema::create('transaksi_setor', function (Blueprint $table) {

            $table->id();

            // Nomor transaksi
            $table->string('kode_transaksi', 50)
                ->unique();

            // Relasi bisnis
            $table->foreignId('bsu_id');

            $table->foreignId('nasabah_id');

            // Tanggal transaksi
            $table->dateTime('tanggal_transaksi');

            // Ringkasan transaksi
            $table->decimal('total_berat', 12, 2)
                ->default(0);

            $table->decimal('total_nilai', 15, 2)
                ->default(0);

            // Status transaksi
            $table->string('status', 20)
                ->default('posted');

            // Catatan tambahan
            $table->text('keterangan')
                ->nullable();

            // Audit
            $table->foreignId('created_by')
                ->nullable();

            $table->foreignId('updated_by')
                ->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Index
            $table->index('kode_transaksi');
            $table->index('bsu_id');
            $table->index('nasabah_id');
            $table->index('tanggal_transaksi');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_setor');
    }
};