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
        Schema::create('harga_sampah', function (Blueprint $table) {

            $table->id();

            // Relasi jenis sampah
            $table->foreignId('jenis_sampah_id');

            // Harga per satuan
            $table->decimal('harga', 15, 2);

            // Periode berlaku
            $table->date('tanggal_berlaku');

            $table->date('tanggal_berakhir')
                ->nullable();

            // Status harga aktif
            $table->boolean('status_aktif')
                ->default(true);

            // Audit
            $table->foreignId('created_by')
                ->nullable();

            $table->foreignId('updated_by')
                ->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Index
            $table->index('jenis_sampah_id');
            $table->index('tanggal_berlaku');
            $table->index('tanggal_berakhir');
            $table->index('status_aktif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('harga_sampah');
    }
};