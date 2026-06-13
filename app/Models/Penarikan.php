<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penarikan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'penarikan';

    protected $fillable = [
        'kode_penarikan',
        'bsu_id',
        'nasabah_id',
        'tanggal_penarikan',
        'saldo_sebelum',
        'jumlah_tarik',
        'saldo_sesudah',
        'status',
        'keterangan',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_penarikan' => 'datetime',
            'saldo_sebelum'     => 'decimal:2',
            'jumlah_tarik'      => 'decimal:2',
            'saldo_sesudah'     => 'decimal:2',
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

    /*
    |--------------------------------------------------------------------------
    | Audit Relationships
    |--------------------------------------------------------------------------
    */

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}