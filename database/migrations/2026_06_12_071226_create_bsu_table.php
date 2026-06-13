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
        Schema::create('bsu', function (Blueprint $table) {

            $table->id();

            // Identitas BSU
            $table->string('kode_bsu', 20)->unique();
            $table->string('nama_bsu', 150);

            // Pengurus
            $table->string('ketua', 150)->nullable();

            // Lokasi
            $table->text('alamat');
            $table->string('kecamatan', 100);

            // Kontak
            $table->string('no_hp', 20)->nullable();

            // Status
            $table->boolean('status')->default(true);

            // Audit
            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Index
            $table->index('kode_bsu');
            $table->index('nama_bsu');
            $table->index('kecamatan');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bsu');
    }
};