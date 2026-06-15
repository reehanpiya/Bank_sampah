<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penarikan;
use App\Services\Penarikan\PenarikanService;
use App\Http\Requests\StorePenarikanRequest;
use App\Models\Bsu;
use App\Models\Nasabah;

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
        $data = Penarikan::with(['nasabah', 'bsu'])
            ->latest()
            ->paginate(10);

        return view('penarikan.index', compact('data'));
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
            $bsus = Bsu::orderBy('nama_bsu')->get();
            $nasabahs = Nasabah::orderBy('nama')->get();

            return view('penarikan.create', compact('bsus', 'nasabahs'));
        }

    public function store(StorePenarikanRequest $request)
    {
        
        try {

            $result = $this->service->create(
                $request->validated()
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