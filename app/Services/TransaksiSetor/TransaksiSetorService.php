<?php

namespace App\Services\TransaksiSetor;

use App\Models\TransaksiSetor;
use App\Models\TransaksiSetorDetail;
use App\Models\HargaSampah;
use App\Services\MutasiSaldo\MutasiSaldoService;
use Illuminate\Support\Facades\DB;
use App\Services\Shared\KodeGeneratorService;
use Illuminate\Support\Facades\Auth;

class TransaksiSetorService
{
    protected MutasiSaldoService $mutasiService;

    public function __construct(MutasiSaldoService $mutasiService)
    {
        $this->mutasiService = $mutasiService;
    }

    /**
     * AMBIL HARGA AKTIF
     */
    private function getHargaAktif(int $jenisSampahId)
    {
        return HargaSampah::where(
            'jenis_sampah_id',
            $jenisSampahId
        )
        ->where('status_aktif', true)
        ->latest('tanggal_berlaku')
        ->first();
    }

    /**
     * CREATE TRANSAKSI SETOR
     */
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {

            $totalNilai = 0;
            $totalBerat = 0;
            $details = [];

            /**
             * 1. HITUNG DETAIL TRANSAKSI
             */
            foreach ($data['items'] as $item) {

                $harga = $this->getHargaAktif($item['jenis_sampah_id']);

                if (!$harga) {
                    throw new \Exception(
                        "Harga tidak ditemukan untuk jenis sampah ID {$item['jenis_sampah_id']}"
                    );
                }

                $subtotal = $item['berat'] * $harga->harga;

                $totalBerat += $item['berat'];
                $totalNilai += $subtotal;

                $details[] = [
                    'jenis_sampah_id' => $item['jenis_sampah_id'],
                    'berat' => $item['berat'],
                    'harga_satuan' => $harga->harga,
                    'subtotal' => $subtotal,
                ];
            }

            /**
             * 2. SIMPAN HEADER TRANSAKSI
             */
            $transaksi = TransaksiSetor::create([
                'kode_transaksi' => KodeGeneratorService::generate(
                    'TS',
                    'transaksi_setor',
                    'kode_transaksi'
                ),
                'bsu_id'           => $data['bsu_id'],
                'nasabah_id'       => $data['nasabah_id'],
                'tanggal_transaksi'=> now(),
                'total_berat'      => $totalBerat,
                'total_nilai'      => $totalNilai,
                'status'           => 'posted',
                'keterangan'       => $data['keterangan'] ?? null,
                'created_by'       => Auth::id(),
            ]);

            /**
             * 3. SIMPAN DETAIL
             */
            foreach ($details as $detail) {
                TransaksiSetorDetail::create([
                    'transaksi_setor_id' => $transaksi->id,
                    ...$detail
                ]);
            }

            /**
             * 4. KIRIM KE LEDGER (MUTASI SALDO)
             */
            $this->mutasiService->create([
                'bsu_id' => $data['bsu_id'],
                'nasabah_id' => $data['nasabah_id'],
                'transaksi_setor_id' => $transaksi->id,
                'jenis_mutasi' => 'kredit',
                'jumlah' => $totalNilai,
                'created_by' => Auth::id(),
                'keterangan' => 'Setor sampah',
            ]);

            return $transaksi;
        });
    }
}