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

    public function create()
    {
        $bsu = Bsu::all();

        $nasabah = Nasabah::all();

        return view(
            'penarikan.create',
            compact(
                'bsu',
                'nasabah'
            )
        );
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
        // return response()->json([
        //     'message' => 'success',
        //     'data' => $data
        // ]);
    }

    /**
     * DETAIL PENARIKAN
     */
    public function show($id)
    {
        $data = Penarikan::with(['nasabah', 'bsu'])
            ->findOrFail($id);

        return view('penarikan.show', compact('data'));
        // return response()->json([
        //     'message' => 'success',
        //     'data' => $data
        // ]);
    }

    /**
     * CREATE PENARIKAN (CORE OUTFLOW)
     */
    public function store(StorePenarikanRequest $request)
    {
        
        try {

            $result = $this->service->create(
                $request->validated()
            );

            return response()->json([
                'message' => 'Penarikan berhasil diproses',
                'data' => $result
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Gagal memproses penarikan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}