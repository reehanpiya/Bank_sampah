<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nasabah;
use App\Http\Requests\StoreNasabahRequest;

class NasabahController extends Controller
{
    /**
     * LIST NASABAH
     */
    public function index()
    {
        $data = Nasabah::with('bsu')
            ->latest()
            ->paginate(10);

        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }

    /**
     * DETAIL NASABAH
     */
    public function show($id)
    {
        $data = Nasabah::with('bsu')
            ->findOrFail($id);

        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }

    /**
     * CREATE NASABAH
     */
    public function store(StoreNasabahRequest $request)
    {
        $data = Nasabah::create([
            ...$request->validated(),
            'status' => true,
        ]);

        return response()->json([
            'message' => 'Nasabah berhasil ditambahkan',
            'data' => $data
        ]);
    }

    /**
     * UPDATE NASABAH
     */
    public function update(Request $request, $id)
    {
        $nasabah = Nasabah::findOrFail($id);

        $request->validate([
            'bsu_id' => 'required|integer',
            'nomor_nasabah' => 'required|unique:nasabah,nomor_nasabah,' . $id,
            'nama' => 'required|string|max:150',
            'alamat' => 'required|string',
            'no_hp' => 'nullable|string|max:20',
            'nik' => 'nullable|string|max:20',
            'status' => 'boolean'
        ]);

        $nasabah->update($request->all());

        return response()->json([
            'message' => 'Nasabah berhasil diupdate',
            'data' => $nasabah
        ]);
    }

    /**
     * DELETE NASABAH
     */
    public function destroy($id)
    {
        $nasabah = Nasabah::findOrFail($id);
        $nasabah->delete();

        return response()->json([
            'message' => 'Nasabah berhasil dihapus'
        ]);
    }
}