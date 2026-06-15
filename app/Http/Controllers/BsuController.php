<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBsuRequest;
use Illuminate\Http\Request;
use App\Models\Bsu;

//otomatis generate user
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
//end otomatis generate user

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

    //new create automatis generate user
    public function store(StoreBsuRequest $request)
    {
        $bsu = Bsu::create(
            $request->validated()
        );

        $namaBsu = Str::lower(
            str_replace(' ', '', $bsu->nama_bsu)
        );

        $email = $namaBsu . $bsu->id . '@banksampah.id';

        $angkaKode = preg_replace(
            '/[^0-9]/',
            '',
            $bsu->kode_bsu
        );

        $passwordPlain = $namaBsu . $angkaKode;

        User::create([
            'bsu_id'   => $bsu->id,
            'name'     => $bsu->nama_bsu,
            'email'    => $email,
            'password' => Hash::make($passwordPlain),
            'role'     => 'admin_bsu',
            'status'   => true,
        ]);

        return redirect()
            ->route('bsu.index')
            ->with(
                'success',
                "BSU berhasil dibuat. Email: {$email} | Password: {$passwordPlain}"
            );
    }
    //end new create automatis generate user

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