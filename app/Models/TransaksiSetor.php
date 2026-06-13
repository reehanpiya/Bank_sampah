<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Bsu;
use App\Models\Nasabah;
use App\Models\TransaksiSetorDetail;
use App\Models\User;

class TransaksiSetor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'transaksi_setor';

    protected $fillable = [
        'kode_transaksi',
        'bsu_id',
        'nasabah_id',
        'tanggal_transaksi',
        'total_berat',
        'total_nilai',
        'status',
        'keterangan',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_transaksi' => 'datetime',
            'total_berat'       => 'decimal:2',
            'total_nilai'       => 'decimal:2',
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

    public function details(): HasMany
    {
        return $this->hasMany(TransaksiSetorDetail::class);
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