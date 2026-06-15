<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransaksiSetorBsu extends Model
{
    use SoftDeletes;

    protected $table = 'transaksi_setor_bsu';

    protected $fillable = [
        'kode_transaksi',
        'bsu_id',
        'tanggal_transaksi',
        'total_berat',
        'total_nilai',
        'status',
        'keterangan',
        'created_by',
        'updated_by',
    ];

    public function bsu()
    {
        return $this->belongsTo(Bsu::class);
    }

    public function details()
    {
        return $this->hasMany(
            TransaksiSetorBsuDetail::class,
            'transaksi_setor_bsu_id'
        );
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}