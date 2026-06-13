<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Bsu;
use App\Models\Nasabah;
use App\Models\TransaksiSetor;
use App\Models\Penarikan;
use App\Models\User;

class MutasiSaldo extends Model
{
    use HasFactory;

    protected $table = 'mutasi_saldo';

    protected $fillable = [
        'bsu_id',
        'nasabah_id',
        'transaksi_setor_id',
        'penarikan_id',
        'jenis_mutasi',
        'saldo_sebelum',
        'jumlah',
        'saldo_sesudah',
        'tanggal_mutasi',
        'keterangan',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'saldo_sebelum'  => 'decimal:2',
            'jumlah'         => 'decimal:2',
            'saldo_sesudah'  => 'decimal:2',
            'tanggal_mutasi' => 'datetime',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Business Relationships
    |--------------------------------------------------------------------------
    */

    public function bsu(): BelongsTo
    {
        return $this->belongsTo(Bsu::class);
    }

    public function nasabah(): BelongsTo
    {
        return $this->belongsTo(Nasabah::class);
    }

    public function transaksiSetor(): BelongsTo
    {
        return $this->belongsTo(TransaksiSetor::class);
    }

    public function penarikan(): BelongsTo
    {
        return $this->belongsTo(Penarikan::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Audit Relationship (minimal)
    |--------------------------------------------------------------------------
    */

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}