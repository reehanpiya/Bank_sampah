<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\HargaSampah;
use App\Models\TransaksiSetorDetail;
use App\Models\User;

class JenisSampah extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jenis_sampah';

    protected $fillable = [
        'kode',
        'nama',
        'satuan',
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

    public function hargaSampahs(): HasMany
    {
        return $this->hasMany(HargaSampah::class);
    }

    public function transaksiSetorDetails(): HasMany
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