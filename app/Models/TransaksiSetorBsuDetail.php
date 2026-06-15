<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiSetorBsuDetail extends Model
{
    protected $table = 'transaksi_setor_bsu_detail';

    protected $fillable = [
        'transaksi_setor_bsu_id',
        'jenis_sampah_id',
        'berat',
        'harga_satuan',
        'subtotal',
    ];

    public function transaksi()
    {
        return $this->belongsTo(
            TransaksiSetorBsu::class,
            'transaksi_setor_bsu_id'
        );
    }

    public function jenisSampah()
    {
        return $this->belongsTo(
            JenisSampah::class,
            'jenis_sampah_id'
        );
    }
}