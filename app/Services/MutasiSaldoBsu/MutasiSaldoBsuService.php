<?php

namespace App\Services\MutasiSaldoBsu;

use App\Models\MutasiSaldoBsu;

class MutasiSaldoBsuService
{
    /**
     * CREATE MUTASI SALDO BSU
     */
    public function create(array $data)
    {
        $lastMutasi = MutasiSaldoBsu::where(
            'bsu_id',
            $data['bsu_id']
        )
        ->latest('id')
        ->first();

        $saldoSebelum =
            $lastMutasi?->saldo_sesudah
            ?? 0;

        if ($data['jenis_mutasi'] === 'kredit') {

            $saldoSesudah =
                $saldoSebelum
                +
                $data['jumlah'];

        } else {

            $saldoSesudah =
                $saldoSebelum
                -
                $data['jumlah'];
        }

        return MutasiSaldoBsu::create([

            'bsu_id' =>
                $data['bsu_id'],

            'transaksi_setor_bsu_id' =>
                $data['transaksi_setor_bsu_id']
                ?? null,

            'jenis_mutasi' =>
                $data['jenis_mutasi'],

            'saldo_sebelum' =>
                $saldoSebelum,

            'jumlah' =>
                $data['jumlah'],

            'saldo_sesudah' =>
                $saldoSesudah,

            'tanggal_mutasi' =>
                now(),

            'keterangan' =>
                $data['keterangan']
                ?? null,

            'created_by' =>
                $data['created_by']
                ?? auth()->id(),
        ]);
    }
}