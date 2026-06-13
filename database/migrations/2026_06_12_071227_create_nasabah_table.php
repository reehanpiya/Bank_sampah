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
        Schema::create('nasabah', function (Blueprint $table) {

            $table->id();

            // Relasi BSU
            $table->foreignId('bsu_id'); 

            // Identitas Nasabah
            $table->string('nomor_nasabah', 30)->unique();

            $table->string('nik', 20)->nullable();

            $table->string('nama', 150);

            $table->text('alamat');

            $table->string('no_hp', 20)->nullable();

            // Status
            $table->boolean('status')->default(true);

            // Audit
            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Index
            $table->index('bsu_id');
            $table->index('nomor_nasabah');
            $table->index('nama');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nasabah');
    }
};