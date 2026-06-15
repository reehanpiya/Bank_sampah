<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisSampah;
use App\Http\Requests\StoreJenisSampahRequest;
use App\Helpers\ActivityLogger;

class JenisSampahController extends Controller
{
    /**
     * LIST JENIS SAMPAH
     */
    public function index()
    {
        $data = JenisSampah::latest()->paginate(10);

        return view('jenis-sampah.index', compact('data'));
    }

    /**
     * DETAIL JENIS SAMPAH
     */
    public function show($id)
    {
        $data = JenisSampah::findOrFail($id);

        return view('jenis-sampah.show', compact('data'));
    }

    /**
     * CREATE JENIS SAMPAH
     */
    public function create()
    {
        return view('jenis-sampah.create');
    }

    public function store(StoreJenisSampahRequest $request)
{
    $data = $request->validated();

    $data['satuan'] = $data['satuan'] ?? 'Kg';
    $data['status'] = true;

    $data['created_by'] = auth()->id();
    $data['updated_by'] = auth()->id();


    $jenis = JenisSampah::create($data);

    ActivityLogger::log(
        'CREATE',
        'JENIS_SAMPAH',
        $jenis->id,
        'Menambah jenis sampah ' . $jenis->nama
    );

    return redirect()
        ->route('jenis-sampah.index')
        ->with('success', 'Jenis sampah berhasil ditambahkan');
}

    /**
     * UPDATE JENIS SAMPAH
     */
    public function edit($id)
    {
        $JenisSampah = JenisSampah::findOrFail($id);
        return view('jenis-sampah.edit', compact('JenisSampah'));
    }

    public function update(Request $request, $id)
    {
        $jenis = JenisSampah::findOrFail($id);

        $request->validate([
            'kode' => 'required|unique:jenis_sampah,kode,' . $id,
            'nama' => 'required|string|max:100',
            'satuan' => 'nullable|string|max:20',
            'status' => 'boolean'
        ]);

        $jenis->update([
            ...$request->all(),
            'updated_by' => auth()->id(),
        ]);


        ActivityLogger::log(
            'CREATE',
            'JENIS_SAMPAH',
            $jenis->id,
            'Menambah jenis sampah ' . $jenis->nama
        );

        return redirect()
            ->route('jenis-sampah.index')
            ->with('success', 'Jenis sampah berhasil diupdate');
    }

    /**
     * DELETE JENIS SAMPAH
     */
    public function destroy($id)
    {
        $jenis = JenisSampah::findOrFail($id);
        $jenis->delete();


        ActivityLogger::log(
            'CREATE',
            'JENIS_SAMPAH',
            $jenis->id,
            'Menambah jenis sampah ' . $jenis->nama
        );

        return redirect()
            ->route('jenis-sampah.index')
            ->with('success', 'Jenis sampah berhasil dihapus');
    }
}