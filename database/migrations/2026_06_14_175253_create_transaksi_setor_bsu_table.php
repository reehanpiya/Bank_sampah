<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi_setor_bsu', function (Blueprint $table) {

            $table->id();

            // nomor transaksi
            $table->string('kode_transaksi', 50)
                ->unique();

            // BSU penerima saldo
            $table->foreignId('bsu_id');

            // tanggal transaksi
            $table->dateTime('tanggal_transaksi');

            // total transaksi
            $table->decimal('total_berat', 12, 2)
                ->default(0);

            $table->decimal('total_nilai', 15, 2)
                ->default(0);

            // status
            $table->string('status', 20)
                ->default('posted');

            $table->text('keterangan')
                ->nullable();

            // audit
            $table->foreignId('created_by')
                ->nullable();

            $table->foreignId('updated_by')
                ->nullable();

            $table->timestamps();
            $table->softDeletes();

            // index
            $table->index('kode_transaksi');
            $table->index('bsu_id');
            $table->index('tanggal_transaksi');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_setor_bsu');
    }
};