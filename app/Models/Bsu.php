<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\Nasabah;
use App\Models\TransaksiSetor;
use App\Models\Penarikan;
use App\Models\MutasiSaldo;

class Bsu extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bsu';

    protected $fillable = [
        'kode_bsu',
        'nama_bsu',
        'ketua',
        'alamat',
        'kecamatan',
        'no_hp',
        'status',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Business Relationships
    |--------------------------------------------------------------------------
    */

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function nasabahs(): HasMany
    {
        return $this->hasMany(Nasabah::class);
    }

    public function transaksiSetors(): HasMany
    {
        return $this->hasMany(TransaksiSetor::class);
    }

    public function penarikans(): HasMany
    {
        return $this->hasMany(Penarikan::class);
    }

    public function mutasiSaldos(): HasMany
    {
        return $this->hasMany(MutasiSaldo::class);
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