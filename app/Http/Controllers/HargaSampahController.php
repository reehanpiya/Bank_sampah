<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HargaSampah;
use App\Http\Requests\StoreHargaSampahRequest;

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

        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }

    /**
     * DETAIL HARGA SAMPAH
     */
    public function show($id)
    {
        $data = HargaSampah::with('jenisSampah')
            ->findOrFail($id);

        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
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

        return response()->json([
            'message' => 'Harga sampah berhasil dibuat',
            'data' => $data
        ]);
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

        return response()->json([
            'message' => 'Harga sampah berhasil diupdate',
            'data' => $harga
        ]);
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