<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MutasiSaldoBsu extends Model
{
    protected $table = 'mutasi_saldo_bsu';

    protected $fillable = [

        'bsu_id',

        'transaksi_setor_bsu_id',

        'jenis_mutasi',

        'saldo_sebelum',

        'jumlah',

        'saldo_sesudah',

        'tanggal_mutasi',

        'keterangan',

        'created_by',
    ];

    /**
     * RELASI BSU
     */
    public function bsu()
    {
        return $this->belongsTo(
            Bsu::class,
            'bsu_id'
        );
    }

    /**
     * RELASI TRANSAKSI SETOR BSU
     */
    public function transaksiSetorBsu()
    {
        return $this->belongsTo(
            TransaksiSetorBsu::class,
            'transaksi_setor_bsu_id'
        );
    }

    /**
     * USER PEMBUAT
     */
    public function creator()
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }
}