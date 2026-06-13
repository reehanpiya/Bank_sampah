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
        Schema::create('activity_logs', function (Blueprint $table) {

            $table->id();

            // User pelaku
            $table->foreignId('user_id');

            // Aktivitas
            $table->string('aksi', 100);

            // Nama modul
            $table->string('modul', 100);

            // ID data terkait
            $table->unsignedBigInteger('referensi_id')
                ->nullable();

            // Detail aktivitas
            $table->text('deskripsi')
                ->nullable();

            // IP Address
            $table->string('ip_address', 45)
                ->nullable();

            // User Agent
            $table->text('user_agent')
                ->nullable();

            $table->timestamps();

            // Index
            $table->index('user_id');
            $table->index('aksi');
            $table->index('modul');
            $table->index('referensi_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};