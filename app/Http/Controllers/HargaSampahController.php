<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HargaSampah;
use App\Http\Requests\StoreHargaSampahRequest;
use App\Models\JenisSampah;

class HargaSampahController extends Controller
{
    /**
     * LIST HARGA SAMPAH
     */
    public function index()
    {
        $data = HargaSampah::with('jenisSampah')
            ->latest()
            ->paginate(10);

        return view('harga-sampah.index', compact('data'));
        // return response()->json([
        //     'message' => 'success',
        //     'data' => $data
        // ]);
    }

    public function create()
    {
        $jenisSampah = JenisSampah::all();
        return view('harga-sampah.create', compact('jenisSampah'));
    }

    public function edit($id)
    {
        $hargaSampah = HargaSampah::findOrFail($id);
        $jenisSampah = JenisSampah::all();

        return view('harga-sampah.edit', compact('hargaSampah', 'jenisSampah'));
    }
    /**
     * DETAIL HARGA SAMPAH
     */
    public function show($id)
    {
        $data = HargaSampah::with('jenisSampah')
            ->findOrFail($id);

        return view('harga-sampah.show', compact('data'));
        // return response()->json([
        //     'message' => 'success',
        //     'data' => $data
        // ]);
    }

    /**
     * CREATE HARGA SAMPAH
     */
    public function store(StoreHargaSampahRequest $request)
    {
        $data = HargaSampah::create([
            ...$request->validated(),
            'status_aktif' => true,
        ]);

        return redirect()
        ->route('harga-sampah.index')
        ->with(
            'success',
            'Harga sampah berhasil dibuat'
        );
        // return response()->json([
        //     'message' => 'Harga sampah berhasil dibuat',
        //     'data' => $data
        // ]);
    }

    /**
     * UPDATE HARGA SAMPAH
     */
    public function update(Request $request, $id)
    {
        $harga = HargaSampah::findOrFail($id);

        $request->validate([
            'jenis_sampah_id' => 'required|integer',
            'harga' => 'required|numeric|min:0',
            'tanggal_berlaku' => 'required|date',
            'tanggal_berakhir' => 'nullable|date',
            'status_aktif' => 'boolean'
        ]);

        $harga->update($request->all());

        return redirect()
            ->route('harga-sampah.index')
            ->with(
                'success',
                'Harga sampah berhasil diupdate'
            );
        // return response()->json([
        //     'message' => 'Harga sampah berhasil diupdate',
        //     'data' => $harga
        // ]);
    }

    /**
     * DELETE HARGA SAMPAH
     */
    public function destroy($id)
    {
        $harga = HargaSampah::findOrFail($id);
        $harga->delete();

        return response()->json([
            'message' => 'Harga sampah berhasil dihapus'
        ]);
    }
}