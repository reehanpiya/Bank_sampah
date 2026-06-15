@extends('layouts.app')

@section('content')

<div class="bg-white rounded-lg shadow p-6">

    
    <h1 class="text-xl font-bold mb-6">
        Edit Nasabah
    </h1>

    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <form
        action="{{ route('nasabah.update', $nasabah->id) }}"
        method="POST">

        @csrf
        @method('PUT')

        <div class="mb-4">

            <label>BSU</label>

            <select
                name="bsu_id"
                class="w-full border rounded p-2">

                <option value="">
                    Pilih BSU
                </option>

                @foreach($bsu as $item)

                <option
                    value="{{ $item->id }}">

                    {{ old('bsu_id', $nasabah->bsu_id ?? '') == $item->id ? 'selected' : '' }}
                    {{ $item->nama_bsu }}

                </option>

                @endforeach

            </select>

        </div>

        <div class="mb-4">

            <label>Nomor Nasabah</label>

            <input
                type="text"
                name="nomor_nasabah"
                value="{{ old('nomor_nasabah', $nasabah->nomor_nasabah ?? '') }}"
                class="w-full border rounded p-2">

        </div>

        <div class="mb-4">

            <label>Nama</label>

            <input
                type="text"
                name="nama"
                value="{{ old('nama', $nasabah->nama ?? '') }}"
                class="w-full border rounded p-2">

        </div>

        <div class="mb-4">

            <label>Alamat</label>

            <textarea
                name="alamat"
                class="w-full border rounded p-2">{{ old('alamat', $nasabah->alamat ?? '') }}</textarea>

        </div>

        <div class="mb-4">

            <label>No HP</label>

            <input
                type="text"
                name="no_hp"
                value="{{ old('no_hp', $nasabah->no_hp ?? '') }}"
                class="w-full border rounded p-2">

        </div>

        <div class="mb-4">

            <label>NIK</label>

            <input
                type="text"
                name="nik"
                value="{{ old('nik', $nasabah->nik ?? '') }}"
                class="w-full border rounded p-2">

        </div>

        <div class="mt-6 flex gap-3">

                <button
                    type="submit"
                    class="px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">

                    Simpan

                </button>

                <a href="{{ route('nasabah.index') }}"
                   class="px-5 py-2 bg-gray-300 rounded-lg">

                    Kembali

                </a>

            </div>

    </form>

</div>

@endsection