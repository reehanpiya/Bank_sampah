<?php

namespace App\Http\Controllers;

use App\Models\TransaksiSetor;
use App\Models\MutasiSaldo;
use Illuminate\Http\Request;
use App\Models\TransaksiSetorDetail;
use App\Models\Bsu;

class ReportController extends Controller
{
    /**
     * HALAMAN UTAMA LAPORAN
     */
    public function index(Request $request)
    {
        $query = TransaksiSetorDetail::with([
            'transaksiSetor.bsu',
            'jenisSampah'
        ]);

        if ($request->filled('tanggal_awal')) {

            $query->whereHas('transaksiSetor', function ($q) use ($request) {

                $q->whereDate(
                    'tanggal_transaksi',
                    '>=',
                    $request->tanggal_awal
                );
            });
        }

        if ($request->filled('tanggal_akhir')) {

            $query->whereHas('transaksiSetor', function ($q) use ($request) {

                $q->whereDate(
                    'tanggal_transaksi',
                    '<=',
                    $request->tanggal_akhir
                );
            });
        }

        if ($request->filled('bsu_id')) {

            $query->whereHas(
                'transaksiSetor',
                function ($q) use ($request) {

                    $q->where(
                        'bsu_id',
                        $request->bsu_id
                    );
                }
            );
        }

        $data = $query
            ->latest()
            ->get();

        $bsu = Bsu::orderBy('nama_bsu')->get();

        return view(
            'laporan.index',
            compact('data')
        );
    }

    /**
     * LAPORAN HARIAN
     */
    public function harian(Request $request)
    {
        $data = TransaksiSetor::with([
            'nasabah',
            'bsu',
            'details.jenisSampah'
        ])
            ->when($request->tanggal_awal, function ($q) use ($request) {
                $q->whereDate(
                    'tanggal_transaksi',
                    '>=',
                    $request->tanggal_awal
                );
            })
            ->when($request->tanggal_akhir, function ($q) use ($request) {
                $q->whereDate(
                    'tanggal_transaksi',
                    '<=',
                    $request->tanggal_akhir
                );
            })
            ->orderBy('tanggal_transaksi')
            ->get();

        return response()->json($data);
    }

    /**
     * LAPORAN BULANAN
     */
    public function bulanan(Request $request)
    {
        $data = TransaksiSetor::query()
            ->when($request->bulan, function ($q) use ($request) {
                $q->whereMonth(
                    'tanggal_transaksi',
                    $request->bulan
                );
            })
            ->when($request->tahun, function ($q) use ($request) {
                $q->whereYear(
                    'tanggal_transaksi',
                    $request->tahun
                );
            })
            ->get();

        return response()->json([
            'total_transaksi' => $data->count(),
            'total_berat' => $data->sum('total_berat'),
            'total_nilai' => $data->sum('total_nilai'),
        ]);
    }

    /**
     * LAPORAN TAHUNAN
     */
    public function tahunan(Request $request)
    {
        $tahun = $request->tahun ?? now()->year;

        $data = TransaksiSetor::whereYear(
            'tanggal_transaksi',
            $tahun
        )->get();

        return response()->json([
            'tahun' => $tahun,
            'total_transaksi' => $data->count(),
            'total_berat' => $data->sum('total_berat'),
            'total_nilai' => $data->sum('total_nilai'),
        ]);
    }

    /**
     * SALDO NASABAH
     */
    public function saldoNasabah()
    {
        $data = MutasiSaldo::with('nasabah')
            ->latest('tanggal_mutasi')
            ->get()
            ->groupBy('nasabah_id')
            ->map(function ($items) {
                return $items->first();
            })
            ->values();

        return response()->json($data);
    }

    /**
     * FORMAT LAPORAN BSI
     */
    public function laporanBsi(Request $request)
    {
        $data = TransaksiSetor::with([
            'bsu',
            'details.jenisSampah'
        ])
            ->when($request->tanggal_awal, function ($q) use ($request) {
                $q->whereDate(
                    'tanggal_transaksi',
                    '>=',
                    $request->tanggal_awal
                );
            })
            ->when($request->tanggal_akhir, function ($q) use ($request) {
                $q->whereDate(
                    'tanggal_transaksi',
                    '<=',
                    $request->tanggal_akhir
                );
            })
            ->get();

        return response()->json($data);
    }
}
