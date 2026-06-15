<?php

namespace App\Services\MutasiSaldo;

use App\Models\MutasiSaldo;
use Illuminate\Support\Facades\DB;

class MutasiSaldoService
{
    /**
     * AMBIL SALDO TERAKHIR NASABAH (SOURCE OF TRUTH)
     */
    public function getSaldoTerakhir(int $nasabahId): float
    {
        $last = MutasiSaldo::where('nasabah_id', $nasabahId)
            ->orderByDesc('id')
            ->first();

        return $last?->saldo_sesudah ?? 0;
    }

    /**
     * HITUNG SALDO BARU (AMAN & CONSISTENT)
     */
    public function hitungSaldoBaru(int $nasabahId, float $jumlah, string $jenisMutasi): array
    {
        $saldoSebelum = $this->getSaldoTerakhir($nasabahId);

        if ($jenisMutasi === 'kredit') {
            $saldoSesudah = $saldoSebelum + $jumlah;
        } elseif ($jenisMutasi === 'debit') {
            $saldoSesudah = $saldoSebelum - $jumlah;

            if ($saldoSesudah < 0) {
                throw new \Exception("Saldo tidak mencukupi");
            }
        } else {
            throw new \Exception("Jenis mutasi tidak valid");
        }

        return [
            'saldo_sebelum' => $saldoSebelum,
            'saldo_sesudah' => $saldoSesudah,
        ];
    }

    /**
     * CREATE MUTASI (ENGINE UTAMA LEDGER)
     */
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {

            // 1. hitung saldo real
            $saldo = $this->hitungSaldoBaru(
                $data['nasabah_id'],
                $data['jumlah'],
                $data['jenis_mutasi']
            );

            // 2. simpan mutasi
            return MutasiSaldo::create([
                'bsu_id'            => $data['bsu_id'],
                'nasabah_id'        => $data['nasabah_id'],
                'transaksi_setor_id'=> $data['transaksi_setor_id'] ?? null,
                'penarikan_id'      => $data['penarikan_id'] ?? null,
                'jenis_mutasi'      => $data['jenis_mutasi'],
                'saldo_sebelum'     => $saldo['saldo_sebelum'],
                'jumlah'            => $data['jumlah'],
                'saldo_sesudah'     => $saldo['saldo_sesudah'],
                'tanggal_mutasi'    => now(),
                'keterangan'        => $data['keterangan'] ?? null,
                'created_by'        => $data['created_by'] ?? Auth::id(),
            ]);
        });
    }
}
