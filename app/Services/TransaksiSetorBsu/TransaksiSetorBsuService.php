<?php

namespace App\Services\TransaksiSetorBsu;

use App\Models\HargaSampah;
use App\Models\TransaksiSetorBsu;
use App\Models\TransaksiSetorBsuDetail;
use Illuminate\Support\Facades\DB;
use App\Services\Shared\KodeGeneratorService;
use App\Services\MutasiSaldoBsu\MutasiSaldoBsuService;

class TransaksiSetorBsuService
{
    protected MutasiSaldoBsuService $mutasiService;

    public function __construct(
        MutasiSaldoBsuService $mutasiService
    ) {
        $this->mutasiService = $mutasiService;
    }

    /**
     * AMBIL HARGA AKTIF
     */
    private function getHargaAktif(
    int $jenisSampahId
    )
    {
        return HargaSampah::where(
            'jenis_sampah_id',
            $jenisSampahId
        )
        ->where('status_aktif', true)
        ->latest('id')
        ->first();
    }

    /**
     * CREATE TRANSAKSI SETOR BSU → BSI
     */
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {

            $totalBerat = 0;
            $totalNilai = 0;
            $details = [];

            /**
             * HITUNG DETAIL
             */
            foreach ($data['items'] as $item) {

                $harga = $this->getHargaAktif(
                    $item['jenis_sampah_id']
                );

                if (!$harga) {

                    throw new \Exception(
                        "Harga tidak ditemukan untuk jenis sampah ID {$item['jenis_sampah_id']}"
                    );
                }

                $subtotal =
                    $item['berat']
                    *
                    $harga->harga;

                $totalBerat += $item['berat'];
                $totalNilai += $subtotal;

                $details[] = [

                    'jenis_sampah_id' =>
                        $item['jenis_sampah_id'],

                    'berat' =>
                        $item['berat'],

                    'harga_satuan' =>
                        $harga->harga,

                    'subtotal' =>
                        $subtotal,
                ];
            }

            /**
             * HEADER
             */
            $transaksi = TransaksiSetorBsu::create([

                'kode_transaksi' =>
                    KodeGeneratorService::generate(
                        'TSB',
                        'transaksi_setor_bsu',
                        'kode_transaksi'
                    ),

                'bsu_id' =>
                    $data['bsu_id'],

                'tanggal_transaksi' =>
                    now(),

                'total_berat' =>
                    $totalBerat,

                'total_nilai' =>
                    $totalNilai,

                'status' =>
                    'posted',

                'keterangan' =>
                    $data['keterangan'] ?? null,

                'created_by' =>
                    auth()->id(),
            ]);

            /**
             * DETAIL
             */
            foreach ($details as &$detail) {

                $detail['transaksi_setor_bsu_id']
                    = $transaksi->id;

                $detail['created_at']
                    = now();

                $detail['updated_at']
                    = now();
            }

            TransaksiSetorBsuDetail::insert(
                $details
            );

            /**
             * MUTASI SALDO BSU
             */
            $this->mutasiService->create([

                'bsu_id' =>
                    $data['bsu_id'],

                'transaksi_setor_bsu_id' =>
                    $transaksi->id,

                'jenis_mutasi' =>
                    'kredit',

                'jumlah' =>
                    $totalNilai,

                'keterangan' =>
                    'Setoran sampah BSU ke BSI',

                'created_by' =>
                    auth()->id(),
            ]);

            return $transaksi;
        });
    }
}