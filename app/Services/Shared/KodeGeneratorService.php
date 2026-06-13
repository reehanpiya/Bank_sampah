<?php

namespace App\Services\Shared;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class KodeGeneratorService
{
    /**
     * Generate kode unik dengan format prefix + tahun + random number
     * Contoh: TRX-2026-000123
     */
    public static function generate(string $prefix, string $table, string $column = 'kode'): string
    {
        $year = date('Y');

        do {
            $number = str_pad((string) random_int(1, 999999), 6, '0', STR_PAD_LEFT);

            $code = "{$prefix}-{$year}-{$number}";

            $exists = DB::table($table)
                ->where($column, $code)
                ->exists();

        } while ($exists);

        return $code;
    }

    /**
     * Versi simple tanpa cek DB (lebih cepat tapi risiko kecil collision)
     */
    public static function generateFast(string $prefix): string
    {
        return $prefix . '-' . date('Y') . '-' . strtoupper(Str::random(6));
    }
}