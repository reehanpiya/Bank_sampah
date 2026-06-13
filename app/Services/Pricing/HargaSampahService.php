<?php

namespace App\Services\Pricing;

use App\Models\HargaSampah;
use Carbon\Carbon;

class HargaSampahService
{
    /**
     * Ambil harga aktif berdasarkan jenis sampah
     */
    public function getHargaAktif(int $jenisSampahId): ?HargaSampah
    {
        return HargaSampah::where('jenis_sampah_id', $jenisSampahId)
            ->where('status_aktif', true)
            ->where(function ($q) {
                $q->whereNull('tanggal_berakhir')
                  ->orWhere('tanggal_berakhir', '>=', Carbon::today());
            })
            ->where('tanggal_berlaku', '<=', Carbon::today())
            ->first();
    }

    /**
     * Hitung subtotal (berat x harga)
     */
    public function hitungSubtotal(float $berat, float $harga): float
    {
        return $berat * $harga;
    }

    /**
     * Validasi apakah harga tersedia
     */
    public function validateHarga(int $jenisSampahId): void
    {
        $harga = $this->getHargaAktif($jenisSampahId);

        if (!$harga) {
            throw new \Exception("Harga aktif tidak ditemukan untuk jenis sampah ID: {$jenisSampahId}");
        }
    }
}