<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBsuRequest;
use Illuminate\Http\Request;
use App\Models\Bsu;

class BsuController extends Controller
{
    /**
     * LIST BSU
     */
    public function index()
    {
        $data = Bsu::latest()->paginate(10);

        return view('bsu.index', compact('data'));
    }

    /**
     * DETAIL BSU
     */
    public function show($id)
    {
        $data = Bsu::findOrFail($id);

        return view('bsu.show', compact('data'));
    }

    /**
     * CREATE BSU
     */
    public function create()
    {
        return view('bsu.create');
    }

    public function store(StoreBsuRequest $request)
    {
        $data = Bsu::create(
            $request->validated()
        );

        return redirect()
        ->route('bsu.index')
        ->with('success', 'BSU berhasil ditambahkan');
    }

    /**
     * UPDATE BSU
     */
    public function edit($id)
    {
        $data = Bsu::findOrFail($id);

        return view('bsu.edit', compact('data'));
    }


    public function update(Request $request, $id)
    {
        $bsu = Bsu::findOrFail($id);

        $request->validate([
            'kode_bsu' => 'required|unique:bsu,kode_bsu,' . $id,
            'nama_bsu' => 'required|string|max:150',
            'ketua' => 'nullable|string|max:150',
            'alamat' => 'required|string',
            'kecamatan' => 'required|string|max:100',
            'no_hp' => 'nullable|string|max:20',
            'status' => 'boolean'
        ]);

        $bsu->update($request->all());

        return redirect()
        ->route('bsu.index')
        ->with('success', 'BSU berhasil diupdate');
    }

    /**
     * DELETE BSU
     */
    public function destroy($id)
    {
        $bsu = Bsu::findOrFail($id);
        $bsu->delete();

        return redirect()
        ->route('bsu.index')
        ->with('success', 'BSU berhasil dihapus');
    }
}