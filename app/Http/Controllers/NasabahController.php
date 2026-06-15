<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nasabah;
use App\Http\Requests\StoreNasabahRequest;
use App\Models\Bsu;
use App\Helpers\ActivityLogger;

class NasabahController extends Controller
{
    /**
     * LIST NASABAH
     */
    public function index()
    {
        $query = Nasabah::with('bsu');

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
            'nasabah.index',
            compact('data')
        );
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

        ActivityLogger::log(
            'CREATE',
            'NASABAH',
            $data->id,
            'Menambah nasabah ' . $data->nama
        );

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

    $validated = $request->validate([
        'bsu_id' => 'required|integer',
        'nomor_nasabah' => 'required|unique:nasabah,nomor_nasabah,' . $id,
        'nama' => 'required|string|max:150',
        'alamat' => 'required|string',
        'no_hp' => 'nullable|string|max:20',
        'nik' => 'nullable|string|max:20',
        'status' => 'boolean',
    ]);

    $nasabah->update([
        ...$validated,
        'updated_by' => auth()->id(),
    ]);

    ActivityLogger::log(
        'UPDATE',
        'NASABAH',
        $nasabah->id,
        'Mengupdate nasabah ' . $nasabah->nama
    );

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

        ActivityLogger::log(
            'DELETE',
            'NASABAH',
            $nasabah->id,
            'Menghapus nasabah ' . $nasabah->nama
        );

        return redirect()
            ->route('nasabah.index')
            ->with('success', 'Nasabah berhasil dihapus');
    }

    public function getByBsu($bsuId)
    {
        $nasabah = Nasabah::where(
            'bsu_id',
            $bsuId
        )
        ->orderBy('nama')
        ->get();

        return response()->json($nasabah);
    }
}