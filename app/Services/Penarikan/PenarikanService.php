<?php

namespace App\Services\Penarikan;

use App\Models\Penarikan;
use App\Services\MutasiSaldo\MutasiSaldoService;
use App\Services\Shared\KodeGeneratorService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PenarikanService
{
    protected MutasiSaldoService $mutasiService;

    public function __construct(MutasiSaldoService $mutasiService)
    {
        $this->mutasiService = $mutasiService;
    }

    /**
     * MAIN PROCESS PENARIKAN
     */
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {

            $nasabahId = $data['nasabah_id'];
            $jumlahTarik = $data['jumlah_tarik'];

            /**
             * 1. AMBIL SALDO ASLI (SOURCE OF TRUTH)
             */
            $saldoSebelum = $this->mutasiService->getSaldoTerakhir($nasabahId);

            /**
             * 2. VALIDASI DASAR
             */
            if ($jumlahTarik <= 0) {
                throw new \Exception("Jumlah penarikan harus lebih dari 0");
            }

            if ($jumlahTarik > $saldoSebelum) {
                throw new \Exception("Saldo tidak mencukupi untuk penarikan");
            }

            $saldoSesudah = $saldoSebelum - $jumlahTarik;

            /**
             * 3. GENERATE KODE
             */
            $kode = KodeGeneratorService::generate(
                'PN',
                'penarikan',
                'kode_penarikan'
            );

            /**
             * 4. SIMPAN PENARIKAN (BUSINESS RECORD)
             */
            $penarikan = Penarikan::create([
                'kode_penarikan'   => $kode,
                'bsu_id'           => $data['bsu_id'],
                'nasabah_id'       => $nasabahId,
                'tanggal_penarikan'=> now(),
                'saldo_sebelum'    => $saldoSebelum,
                'jumlah_tarik'     => $jumlahTarik,
                'saldo_sesudah'    => $saldoSesudah,
                'status'           => 'posted',
                'keterangan'       => $data['keterangan'] ?? null,
                'created_by'       => Auth::id(),
            ]);

            /**
             * 5. LEDGER (WAJIB VIA MUTASI SERVICE)
             */
            $this->mutasiService->create([
                'bsu_id'            => $data['bsu_id'],
                'nasabah_id'        => $nasabahId,
                'penarikan_id'      => $penarikan->id,
                'jenis_mutasi'      => 'debit',
                'jumlah'            => $jumlahTarik,
                'keterangan'        => 'Penarikan saldo',
                'created_by'        => Auth::id(),
            ]);

            return $penarikan;
        });
    }
}