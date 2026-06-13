<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransaksiSetor\TransaksiSetorService;
use App\Models\TransaksiSetor;
use App\Http\Requests\StoreTransaksiSetorRequest;

class TransaksiSetorController extends Controller
{
    protected TransaksiSetorService $service;

    public function __construct(TransaksiSetorService $service)
    {
        $this->service = $service;
    }

    /**
     * LIST TRANSAKSI SETOR
     */
    public function index()
    {
        $data = TransaksiSetor::with(['nasabah', 'bsu'])
            ->latest()
            ->paginate(10);

        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }

    /**
     * DETAIL TRANSAKSI SETOR
     */
    public function show($id)
    {
        $data = TransaksiSetor::with([
                'nasabah',
                'bsu',
                'details'
            ])
            ->findOrFail($id);

        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }

    /**
     * CREATE TRANSAKSI SETOR (CORE FLOW)
     */
    public function store(StoreTransaksiSetorRequest $request)
    {
        try {

            $result = $this->service->create(
                $request->validated()
            );

            return response()->json([
                'message' => 'Transaksi setor berhasil diproses',
                'data' => $result
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Gagal memproses transaksi',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}