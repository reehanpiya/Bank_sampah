<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HargaSampah;
use App\Http\Requests\StoreHargaSampahRequest;
use App\Models\JenisSampah;
use Illuminate\Support\Facades\DB;

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
    }

    /**
     * DETAIL HARGA SAMPAH
     */
    public function show($id)
    {
        $data = HargaSampah::with('jenisSampah')
            ->findOrFail($id);

        return view('harga-sampah.show', compact('data'));
    }

    /**
     * CREATE HARGA SAMPAH
     */
    

    public function create()
    {
        $jenisSampah = JenisSampah::where('status', true)
            ->orderBy('nama')
            ->get();

        return view(
            'harga-sampah.create',
            compact('jenisSampah')
        );
    }
    
    public function store(StoreHargaSampahRequest $request)
    {
        DB::transaction(function () use ($request) {

            HargaSampah::where(
                'jenis_sampah_id',
                $request->jenis_sampah_id
            )
            ->where('status_aktif', true)
            ->update([
                'status_aktif' => false,
                'tanggal_berakhir' => now(),
                'updated_by' => auth()->id(),
            ]);

            HargaSampah::create([
                ...$request->validated(),
                'status_aktif' => true,
                'tanggal_berakhir' => null,
                'created_by' => auth()->id(),
            ]);
        });

        return redirect()
            ->route('harga-sampah.index')
            ->with('success', 'Harga sampah berhasil ditambahkan');
    }
    /**
     * UPDATE HARGA SAMPAH
     */
    public function edit($id)
    {
        $hargaSampah = HargaSampah::findOrFail($id);

        $jenisSampah = JenisSampah::where('status', true)
            ->orderBy('nama')
            ->get();

        return view(
            'harga-sampah.edit',
            compact(
                'hargaSampah',
                'jenisSampah'
            )
        );
    }

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

        $harga->update([
            ...$request->all(),
            'updated_by' => auth()->id(),
        ]);

        return redirect()
            ->route('harga-sampah.index')
            ->with('success', 'Harga sampah berhasil diupdate');
    }

    /**
     * DELETE HARGA SAMPAH
     */
    public function destroy($id)
    {
        $harga = HargaSampah::findOrFail($id);
        $harga->delete();

        return redirect()
            ->route('harga-sampah.index')
            ->with('success', 'Harga sampah berhasil dihapus');
    }
}