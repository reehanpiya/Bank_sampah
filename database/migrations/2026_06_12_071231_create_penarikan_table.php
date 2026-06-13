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
        Schema::create('penarikan', function (Blueprint $table) {

            $table->id();

            // Nomor transaksi penarikan
            $table->string('kode_penarikan', 50)
                ->unique();

            // Relasi bisnis
            $table->foreignId('bsu_id');

            $table->foreignId('nasabah_id');

            // Tanggal penarikan
            $table->dateTime('tanggal_penarikan');

            // Audit saldo
            $table->decimal('saldo_sebelum', 15, 2);

            $table->decimal('jumlah_tarik', 15, 2);

            $table->decimal('saldo_sesudah', 15, 2);

            // Status transaksi
            $table->string('status', 20)
                ->default('posted');

            // Catatan
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
            $table->index('kode_penarikan');
            $table->index('bsu_id');
            $table->index('nasabah_id');
            $table->index('tanggal_penarikan');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penarikan');
    }
};