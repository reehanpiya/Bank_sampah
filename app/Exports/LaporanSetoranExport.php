<?php

namespace App\Exports;

use App\Models\TransaksiSetor;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanSetoranExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = TransaksiSetor::with([
            'bsu',
            'nasabah'
        ]);

        if (auth()->user()->role === 'admin_bsu') {

            $query->where(
                'bsu_id',
                auth()->user()->bsu_id
            );
        }

        if ($this->request->filled('tanggal_awal')) {

            $query->whereDate(
                'tanggal_transaksi',
                '>=',
                $this->request->tanggal_awal
            );
        }

        if ($this->request->filled('tanggal_akhir')) {

            $query->whereDate(
                'tanggal_transaksi',
                '<=',
                $this->request->tanggal_akhir
            );
        }

        return $query->get()->map(function ($item) {

            return [

                'tanggal' =>
                    $item->tanggal_transaksi,

                'kode_transaksi' =>
                    $item->kode_transaksi,

                'bsu' =>
                    $item->bsu->nama_bsu ?? '-',

                'nasabah' =>
                    $item->nasabah->nama ?? '-',

                'total_berat' =>
                    $item->total_berat,

                'total_nilai' =>
                    $item->total_nilai,
            ];
        });
    }

    public function headings(): array
    {
        return [

            'Tanggal',
            'Kode Transaksi',
            'BSU',
            'Nasabah',
            'Total Berat (Kg)',
            'Total Nilai (Rp)',
        ];
    }
}