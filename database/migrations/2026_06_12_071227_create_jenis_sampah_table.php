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
        Schema::create('jenis_sampah', function (Blueprint $table) {

            $table->id();

            // Identitas Jenis Sampah
            $table->string('kode', 20)->unique();

            $table->string('nama', 100);

            $table->string('satuan', 20)
                ->default('Kg');

            // Status
            $table->boolean('status')
                ->default(true);

            // Audit
            $table->foreignId('created_by')
                ->nullable();

            $table->foreignId('updated_by')
                ->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Index
            $table->index('kode');
            $table->index('nama');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_sampah');
    }
};