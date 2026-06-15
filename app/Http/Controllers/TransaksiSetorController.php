<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransaksiSetor\TransaksiSetorService;
use App\Models\TransaksiSetor;
use App\Http\Requests\StoreTransaksiSetorRequest;
use App\Models\Bsu;
use App\Models\Nasabah;
use App\Models\JenisSampah;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ActivityLogger;



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
        $query = TransaksiSetor::with([
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
            'transaksi-setor.index',
            compact('data')
        );
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

        return view('transaksi-setor.show', compact('data'));
    }

    /**
     * CREATE TRANSAKSI SETOR (CORE FLOW)
     */
    public function create()
    {
        

        $jenisSampah = JenisSampah::where('status', true)
            ->orderBy('nama')
            ->get();

        if(auth()->user()->role == 'admin_bsu')
        {
            $nasabah = Nasabah::where(
                'bsu_id',
                auth()->user()->bsu_id
            )->where(
                'status',
                true
            )->orderBy('nama')
            ->get();

            return view(
                'transaksi-setor.create',
                compact(
                    'jenisSampah',
                    'nasabah'
                )
            );
        }

        $bsu = Bsu::where('status', true)
            ->orderBy('nama_bsu')
            ->get();

        $nasabah = Nasabah::where('status', true)
            ->orderBy('nama')
            ->get();

        return view(
            'transaksi-setor.create',
            compact(
                'jenisSampah',
                'bsu',
                'nasabah'
            )
        );
    }

    public function store(StoreTransaksiSetorRequest $request)
    {
        // dd($request->all());
        // dd($request->validated());
        try {

            $result = $this->service->create(
                $request->validated()
            );

            try {

                ActivityLogger::log(
                    'CREATE',
                    'TRANSAKSI_SETOR',
                    $result->id,
                    'Menambah transaksi setor'
                );

            } catch (\Exception $e) {

                dd($e->getMessage());
            }

            return redirect()
                ->route('transaksi-setor.index')
                ->with('success', 'Transaksi setor berhasil diproses');

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Gagal memproses transaksi',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}