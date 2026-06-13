<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisSampah;
use App\Http\Requests\StoreJenisSampahRequest;

class JenisSampahController extends Controller
{
    /**
     * LIST JENIS SAMPAH
     */
    public function index()
    {
        $data = JenisSampah::latest()->paginate(10);

        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }

    /**
     * DETAIL JENIS SAMPAH
     */
    public function show($id)
    {
        $data = JenisSampah::findOrFail($id);

        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }

    /**
     * CREATE JENIS SAMPAH
     */
    public function store(StoreJenisSampahRequest $request)
    {
        $data = $request->validated();

        $data['satuan'] = $data['satuan'] ?? 'Kg';
        $data['status'] = true;

        $jenis = JenisSampah::create($data);

        return response()->json([
            'message' => 'Jenis sampah berhasil dibuat',
            'data' => $jenis
        ]);
    }

    /**
     * UPDATE JENIS SAMPAH
     */
    public function update(Request $request, $id)
    {
        $jenis = JenisSampah::findOrFail($id);

        $request->validate([
            'kode' => 'required|unique:jenis_sampah,kode,' . $id,
            'nama' => 'required|string|max:100',
            'satuan' => 'nullable|string|max:20',
            'status' => 'boolean'
        ]);

        $jenis->update($request->all());

        return response()->json([
            'message' => 'Jenis sampah berhasil diupdate',
            'data' => $jenis
        ]);
    }

    /**
     * DELETE JENIS SAMPAH
     */
    public function destroy($id)
    {
        $jenis = JenisSampah::findOrFail($id);
        $jenis->delete();

        return response()->json([
            'message' => 'Jenis sampah berhasil dihapus'
        ]);
    }
}