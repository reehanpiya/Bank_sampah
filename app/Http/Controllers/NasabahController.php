<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nasabah;
use App\Http\Requests\StoreNasabahRequest;
use App\Models\Bsu;

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

        return view('nasabah.index', compact('data'));
    }

    /**
     * DETAIL NASABAH
     */
    public function show($id)
    {
        $data = Nasabah::with('bsu')
            ->findOrFail($id);

        return view('nasabah.show', compact('data'));
    }

    /**
     * CREATE NASABAH
     */
    public function create()
    {
        $bsu = Bsu::where('status', true)
            ->orderBy('nama_bsu')
            ->get();

        return view(
            'nasabah.create',
            compact('bsu')
        );
    }

    public function store(StoreNasabahRequest $request)
    {
        $data = Nasabah::create([
            ...$request->validated(),
            'status' => true,
            'created_by' => auth()->id(),
        ]);

        return redirect()
            ->route('nasabah.index')
            ->with('success', 'Nasabah berhasil ditambahkan');
    }

    /**
     * UPDATE NASABAH
     */
    public function edit($id)
    {
        $nasabah = Nasabah::findOrFail($id);

        $bsu = Bsu::where('status', true)
            ->orderBy('nama_bsu')
            ->get();

        return view(
            'nasabah.edit',
            compact('nasabah', 'bsu')
        );
    }

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
            'status' => 'boolean',
            
        ]);

        $nasabah->update([
            ...$request->all(),
            'updated_by' => auth()->id(),
        ]);

        return redirect()
            ->route('nasabah.index')
            ->with('success', 'Nasabah berhasil diupdate');
    }

    /**
     * DELETE NASABAH
     */
    public function destroy($id)
    {
        $nasabah = Nasabah::findOrFail($id);
        $nasabah->delete();

        return redirect()
            ->route('nasabah.index')
            ->with('success', 'Nasabah berhasil dihapus');
    }
}