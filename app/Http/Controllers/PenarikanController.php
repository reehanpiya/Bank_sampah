<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penarikan;
use App\Services\Penarikan\PenarikanService;
use App\Http\Requests\StorePenarikanRequest;
use App\Models\Bsu;
use App\Models\Nasabah;
use App\Helpers\ActivityLogger;

class PenarikanController extends Controller
{
    protected PenarikanService $service;

    public function __construct(PenarikanService $service)
    {
        $this->service = $service;
    }

    /**
     * LIST PENARIKAN
     */
    public function index()
    {
        $query = Penarikan::with([
            'nasabah',
            'bsu'
        ]);

        if(auth()->user()->role == 'admin_bsu')
        {
            $query->where(
                'bsu_id',
                auth()->user()->bsu_id
            );
        }

        $data = $query
            ->latest()
            ->paginate(10);

        return view(
            'penarikan.index',
            compact('data')
        );
    }

    /**
     * DETAIL PENARIKAN
     */
    public function show($id)
    {
        $data = Penarikan::with(['nasabah', 'bsu'])
            ->findOrFail($id);

        return view('penarikan.show', compact('data'));
    }

    /**
     * CREATE PENARIKAN (CORE OUTFLOW)
     */
    public function create()
    {
        if(auth()->user()->role == 'admin_bsu')
        {
            $nasabahs = Nasabah::where(
                'bsu_id',
                auth()->user()->bsu_id
            )
            ->where('status', true)
            ->orderBy('nama')
            ->get();

            return view(
                'penarikan.create',
                compact('nasabahs')
            );
        }

        $bsus = Bsu::orderBy('nama_bsu')->get();

        $nasabahs = Nasabah::orderBy('nama')->get();

        return view(
            'penarikan.create',
            compact(
                'bsus',
                'nasabahs'
            )
        );
    }

    public function store(StorePenarikanRequest $request)
    {
        
        try {

            $result = $this->service->create(
                $request->validated()
            );

            ActivityLogger::log(
            'CREATE',
            'PENARIKAN',
            $result->id ?? null,
            'Transaksi penarikan dibuat'
        );

            return redirect()
                ->route('penarikan.index')
                ->with('success', 'Penarikan berhasil diproses');

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Gagal memproses penarikan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
}