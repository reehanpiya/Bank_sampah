<?php

namespace App\Helpers;

use App\Models\ActivityLog;

class ActivityLogger
{
    public static function log(
        string $aksi,
        string $modul,
        ?int $referensiId = null,
        ?string $deskripsi = null
    ): void {


        ActivityLog::create([
            'user_id'      => auth()->id(),
            'aksi'         => $aksi,
            'modul'        => $modul,
            'referensi_id' => $referensiId,
            'deskripsi'    => $deskripsi,
            'ip_address'   => request()->ip(),
            'user_agent'   => request()->userAgent(),
        ]);
    }
}