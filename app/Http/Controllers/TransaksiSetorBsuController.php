<?php

namespace App\Http\Controllers;

use App\Models\Bsu;
use App\Models\JenisSampah;
use App\Models\TransaksiSetorBsu;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTransaksiSetorBsuRequest;
use App\Services\TransaksiSetorBsu\TransaksiSetorBsuService;
use App\Helpers\ActivityLogger;

class TransaksiSetorBsuController extends Controller
{
    protected TransaksiSetorBsuService $service;

    public function __construct(
        TransaksiSetorBsuService $service
    ) {
        $this->service = $service;
    }

    /**
     * LIST TRANSAKSI
     */
    public function index()
    {
        $transaksi = TransaksiSetorBsu::with('bsu')
            ->latest()
            ->paginate(10);

        return view(
            'transaksi-setor-bsu.index',
            compact('transaksi')
        );
    }

    /**
     * FORM CREATE
     */
    public function create()
    {
        $bsu = Bsu::where(
            'status',
            true
        )->orderBy(
            'nama_bsu'
        )->get();

        $jenisSampah = JenisSampah::where(
            'status',
            true
        )->orderBy(
            'nama'
        )->get();

        return view(
            'transaksi-setor-bsu.create',
            compact(
                'bsu',
                'jenisSampah'
            )
        );
    }

    /**
     * SIMPAN TRANSAKSI
     */
    public function store(
        StoreTransaksiSetorBsuRequest $request
    ) {
        try {

            $result = $this->service->create(
                $request->validated()
            );

            ActivityLogger::log(
                'CREATE',
                'SETORAN_BSU',
                $result->id ?? null,
                'Setoran BSU dibuat'
            );

            return redirect()
                ->route(
                    'transaksi-setor-bsu.index'
                )
                ->with(
                    'success',
                    'Transaksi setor BSU berhasil diproses'
                );

        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }

    /**
     * DETAIL
     */
    public function show($id)
    {
        $transaksi = TransaksiSetorBsu::with([
            'bsu',
            'details.jenisSampah'
        ])->findOrFail($id);

        return view(
            'transaksi-setor-bsu.show',
            compact('transaksi')
        );
    }

    /**
     * HAPUS
     */
    public function destroy($id)
    {
        $transaksi = TransaksiSetorBsu::findOrFail($id);

        $transaksi->delete();

        return redirect()
            ->route(
                'transaksi-setor-bsu.index'
            )
            ->with(
                'success',
                'Transaksi berhasil dihapus'
            );
    }
}