<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransaksiSetor\TransaksiSetorService;
use App\Models\TransaksiSetor;
use App\Http\Requests\StoreTransaksiSetorRequest;
use App\Models\Bsu;
use App\Models\Nasabah;
use App\Models\JenisSampah;

class TransaksiSetorController extends Controller
{
    protected TransaksiSetorService $service;

    public function __construct(TransaksiSetorService $service)
    {
        $this->service = $service;
    }

    public function create()
    {
        $bsu = Bsu::where('status', true)->get();

        $nasabah = Nasabah::where('status', true)->get();

        $jenisSampah = JenisSampah::where('status', true)->get();

        return view(
            'transaksi-setor.create',
            compact(
                'bsu',
                'nasabah',
                'jenisSampah'
            )
        );
    }

    /**
     * LIST TRANSAKSI SETOR
     */
    public function index()
    {
        $data = TransaksiSetor::with(['nasabah', 'bsu'])
            ->latest()
            ->paginate(10);

        return view('transaksi-setor.index', compact('data'));
        // return response()->json([
        //     'message' => 'success',
        //     'data' => $data
        // ]);
    }

    /**
     * DETAIL TRANSAKSI SETOR
     */
    public function show($id)
    {
        $data = TransaksiSetor::with([
                'nasabah',
                'bsu',
                'details.jenisSampah'
            ])
            ->findOrFail($id);

        return view('transaksi-setor.show', compact('data'));
        // return response()->json([
        //     'message' => 'success',
        //     'data' => $data
        // ]);
    }

    /**
     * CREATE TRANSAKSI SETOR (CORE FLOW)
     */
    public function store(StoreTransaksiSetorRequest $request)
    {
       $transaksi = $this->service->create($request->validated());

    return redirect()
        ->route('transaksi-setor.index')
        ->with('success', 'Transaksi setor berhasil diproses');
    }
}