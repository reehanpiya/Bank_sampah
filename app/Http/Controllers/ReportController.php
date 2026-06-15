<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiSetor;
use App\Models\MutasiSaldo;
use App\Models\MutasiSaldoBsu;
use App\Exports\LaporanSetoranExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Bsu;
use App\Models\Nasabah;
use App\Models\Penarikan;


class ReportController extends Controller
{
    /**
     * LAPORAN SETORAN NASABAH
     */
    public function index(Request $request)
{
    $query = TransaksiSetor::with([
        'bsu',
        'nasabah',
    ]);

    /**
     * FILTER BSU
     */
    if ($request->filled('bsu_id')) {

        $query->where(
            'bsu_id',
            $request->bsu_id
        );
    }

    /**
     * FILTER NASABAH
     */
    if ($request->filled('nasabah_id')) {

        $query->where(
            'nasabah_id',
            $request->nasabah_id
        );
    }

    /**
     * ADMIN BSU HANYA LIHAT DATA BSU SENDIRI
     */
    if (auth()->user()->role === 'admin_bsu') {

        $query->where(
            'bsu_id',
            auth()->user()->bsu_id
        );
    }

    /**
     * FILTER TANGGAL AWAL
     */
    if ($request->filled('tanggal_awal')) {

        $query->whereDate(
            'tanggal_transaksi',
            '>=',
            $request->tanggal_awal
        );
    }

    /**
     * FILTER TANGGAL AKHIR
     */
    if ($request->filled('tanggal_akhir')) {

        $query->whereDate(
            'tanggal_transaksi',
            '<=',
            $request->tanggal_akhir
        );
    }

    $data = $query
        ->latest('tanggal_transaksi')
        ->paginate(10)
        ->withQueryString();

    $bsu = Bsu::orderBy('nama_bsu')->get();
    $nasabah = Nasabah::orderBy('nama')->get();

    return view(
        'report.index',
        compact(
            'data',
            'bsu',
            'nasabah'
        )
    );

    
}

public function show($id)
    {
        $transaksi = TransaksiSetor::with([
            'bsu',
            'nasabah',
            'details.jenisSampah'
        ])->findOrFail($id);

        return view(
            'report.show',
            compact('transaksi')
        );
    }

    /**
     * LAPORAN HARIAN
     */
    public function harian()
    {
        $data = TransaksiSetor::with([
            'bsu',
            'nasabah'
        ])
        ->whereDate(
            'tanggal_transaksi',
            today()
        )
        ->latest()
        ->paginate(10);

        return view(
            'report.harian',
            compact('data')
        );
    }

    /**
     * LAPORAN BULANAN
     */
    public function bulanan()
    {
        $data = TransaksiSetor::with([
            'bsu',
            'nasabah'
        ])
        ->whereMonth(
            'tanggal_transaksi',
            now()->month
        )
        ->whereYear(
            'tanggal_transaksi',
            now()->year
        )
        ->latest()
        ->paginate(10);

        return view(
            'report.bulanan',
            compact('data')
        );
    }

    /**
     * LAPORAN TAHUNAN
     */
    public function tahunan()
    {
        $data = TransaksiSetor::with([
            'bsu',
            'nasabah'
        ])
        ->whereYear(
            'tanggal_transaksi',
            now()->year
        )
        ->latest()
        ->paginate(10);

        return view(
            'report.tahunan',
            compact('data')
        );
    }

    /**
     * LAPORAN SALDO NASABAH
     */
    public function saldoNasabah()
    {
        $data = MutasiSaldo::with([
            'nasabah',
            'bsu'
        ])
        ->latest()
        ->paginate(10);

        return view(
            'report.saldo-nasabah',
            compact('data')
        );
    }

    /**
     * LAPORAN SALDO BSU
     */
    public function laporanBsi()
    {
        $data = MutasiSaldoBsu::with([
            'bsu'
        ])
        ->latest()
        ->paginate(10);

        return view(
            'report.bsi',
            compact('data')
        );
    }

    public function exportCsv(Request $request)
    {
        $query = TransaksiSetor::with([
            'bsu',
            'nasabah'
        ]);

        if (auth()->user()->role === 'admin_bsu') {

            $nasabah = Nasabah::where(
                'bsu_id',
                auth()->user()->bsu_id
            )
            ->orderBy('nama')
            ->get();

        } else {

            $nasabah = Nasabah::orderBy('nama')->get();
        }

        if ($request->filled('tanggal_awal')) {

            $query->whereDate(
                'tanggal_transaksi',
                '>=',
                $request->tanggal_awal
            );
        }

        if ($request->filled('tanggal_akhir')) {

            $query->whereDate(
                'tanggal_transaksi',
                '<=',
                $request->tanggal_akhir
            );
        }

        $data = $query
            ->latest('tanggal_transaksi')
            ->get();

        $filename =
            'laporan-setoran-'
            .
            now()->format('YmdHis')
            .
            '.csv';

        $headers = [

            'Content-Type' => 'text/csv',
            'Content-Disposition' =>
                "attachment; filename={$filename}",
        ];

        return response()->stream(function () use ($data) {

            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Tanggal',
                'Kode Transaksi',
                'BSU',
                'Nasabah',
                'Total Berat',
                'Total Nilai',
            ]);

            foreach ($data as $item) {

                fputcsv($file, [

                    $item->tanggal_transaksi,

                    $item->kode_transaksi,

                    $item->bsu->nama_bsu ?? '-',

                    $item->nasabah->nama ?? '-',

                    $item->total_berat,

                    $item->total_nilai,
                ]);
            }

            fclose($file);

        }, 200, $headers);
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new LaporanSetoranExport($request),
            'laporan-setoran-' . now()->format('YmdHis') . '.xlsx'
        );
    }

    public function summary()
    {
        $totalSetoran = TransaksiSetor::sum(
        'total_nilai'
        );

        $totalPenarikan = Penarikan::sum(
            'jumlah'
        );
    }

    
}