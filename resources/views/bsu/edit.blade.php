@extends('layouts.app')

@section('content')

<div class="p-6 max-w-4xl mx-auto">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Edit BSU
        </h1>

        <p class="text-sm text-gray-500">
            Form edit Bank Sampah Unit
        </p>
    </div>

    <div class="bg-white rounded-xl shadow p-6">

        <form action="{{ route('bsu.update', $data->id) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block mb-2 text-sm font-medium">
                        Kode BSU
                    </label>

                    <input
                        type="text"
                        name="kode_bsu"
                        value="{{ old('kode_bsu', $data->kode_bsu) }}"
                        class="w-full border rounded-lg px-3 py-2">

                    @error('kode_bsu')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium">
                        Nama BSU
                    </label>

                    <input
                        type="text"
                        name="nama_bsu"
                        value="{{ old('nama_bsu', $data->nama_bsu) }}"
                        class="w-full border rounded-lg px-3 py-2">

                    @error('nama_bsu')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium">
                        Ketua
                    </label>

                    <input
                        type="text"
                        name="ketua"
                        value="{{ old('ketua', $data->ketua) }}"
                        class="w-full border rounded-lg px-3 py-2">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium">
                        Kecamatan
                    </label>

                    <input
                        type="text"
                        name="kecamatan"
                        value="{{ old('kecamatan', $data->kecamatan) }}"
                        class="w-full border rounded-lg px-3 py-2">

                    @error('kecamatan')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>

            </div>

            <div class="mt-4">
                <label class="block mb-2 text-sm font-medium">
                    Nomor HP
                </label>

                <input
                    type="text"
                    name="no_hp"
                    value="{{ old('no_hp', $data->no_hp) }}"
                    class="w-full border rounded-lg px-3 py-2">
            </div>

            <div class="mt-4">
                <label class="block mb-2 text-sm font-medium">
                    Alamat
                </label>

                <textarea
                    name="alamat"
                    rows="4"
                    class="w-full border rounded-lg px-3 py-2">{{ old('alamat', $data->alamat) }}</textarea>

                @error('alamat')
                    <small class="text-red-500">{{ $message }}</small>
                @enderror
            </div>

            <div class="mt-6 flex gap-3">

                <button
                    type="submit"
                    class="px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">

                    Simpan

                </button>

                <a href="{{ route('bsu.index') }}"
                   class="px-5 py-2 bg-gray-300 rounded-lg">

                    Kembali

                </a>

            </div>

        </form>

    </div>

</div>

@endsection