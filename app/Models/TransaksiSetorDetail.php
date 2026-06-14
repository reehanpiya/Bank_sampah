<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\TransaksiSetor;
use App\Models\JenisSampah;

class TransaksiSetorDetail extends Model
{
    use HasFactory;

    protected $table = 'transaksi_setor_detail';

    protected $fillable = [
        'transaksi_setor_id',
        'jenis_sampah_id',
        'berat',
        'harga_satuan',
        'subtotal',
    ];

    protected function casts(): array
    {
        return [
            'berat'        => 'decimal:2',
            'harga_satuan' => 'decimal:2',
            'subtotal'     => 'decimal:2',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Business Relationships
    |--------------------------------------------------------------------------
    */

    public function transaksiSetor(): BelongsTo
    {
        return $this->belongsTo(TransaksiSetor::class);
    }

    public function jenisSampah(): BelongsTo
    {
        return $this->belongsTo(JenisSampah::class);
    }

    
}