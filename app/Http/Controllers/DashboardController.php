<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bsu;
use App\Models\Nasabah;          
use App\Models\TransaksiSetor;   
use App\Models\MutasiSaldo;

class DashboardController extends Controller
{
    public function index()
    {
        if(auth()->user()->role === 'admin_bsu')
        {
            $bsuId = auth()->user()->bsu_id;

            $totalBsu = 1;

            $totalNasabah = Nasabah::where(
                'bsu_id',
                $bsuId
            )->count();

            $totalSampah = TransaksiSetor::where(
                'bsu_id',
                $bsuId
            )->sum('total_berat');

            $totalTabungan = MutasiSaldo::where(
                'bsu_id',
                $bsuId
            )->sum('jumlah');

            $chartSetor = TransaksiSetor::selectRaw('
                    MONTH(tanggal_transaksi) as bulan,
                    SUM(total_nilai) as total
                ')
                ->where('bsu_id', $bsuId)
                ->groupBy('bulan')
                ->orderBy('bulan')
                ->get();

            $transaksiTerbaru = TransaksiSetor::with(
                    'nasabah'
                )
                ->where(
                    'bsu_id',
                    $bsuId
                )
                ->latest()
                ->take(10)
                ->get();
        }
        else
        {
            $totalBsu = Bsu::count();

            $totalNasabah = Nasabah::count();

            $totalSampah = TransaksiSetor::sum(
                'total_berat'
            );

            $totalTabungan = MutasiSaldo::sum(
                'jumlah'
            );

            $chartSetor = TransaksiSetor::selectRaw('
                    MONTH(tanggal_transaksi) as bulan,
                    SUM(total_nilai) as total
                ')
                ->groupBy('bulan')
                ->orderBy('bulan')
                ->get();

            $transaksiTerbaru = TransaksiSetor::with(
                    'nasabah'
                )
                ->latest()
                ->take(10)
                ->get();
        }

        return view(
            'dashboard.index',
            compact(
                'totalBsu',
                'totalNasabah',
                'totalSampah',
                'totalTabungan',
                'chartSetor',
                'transaksiTerbaru'
            )
        );
    }
}
