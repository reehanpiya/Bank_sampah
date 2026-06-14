@extends('layouts.app')

@section('content')

<div class="p-6 max-w-4xl mx-auto">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Tambah Jenis Sampah
        </h1>

        <p class="text-sm text-gray-500">
            Form tambah jenis sampah
        </p>
    </div>

    <div class="bg-white rounded-xl shadow p-6">

        <form action="{{ route('jenis-sampah.store') }}" method="POST">

            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block mb-2 text-sm font-medium">
                        Kode Jenis Sampah
                    </label>

                    <input
                        type="text"
                        name="kode"
                        value="{{ old('kode') }}"
                        class="w-full border rounded-lg px-3 py-2">

                    @error('kode')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium">
                        Nama Jenis Sampah
                    </label>

                    <input
                        type="text"
                        name="nama"
                        value="{{ old('nama') }}"
                        class="w-full border rounded-lg px-3 py-2">

                    @error('nama')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium">
                        Satuan
                    </label>

                    <input
                        type="text"
                        name="satuan"
                        value="{{ old('satuan') }}"
                        class="w-full border rounded-lg px-3 py-2">
                </div>

            </div>


            <div class="mt-6 flex gap-3">

                <button
                    type="submit"
                    class="px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">

                    Simpan

                </button>

                <a href="{{ route('jenis-sampah.index') }}"
                   class="px-5 py-2 bg-gray-300 rounded-lg">

                    Kembali

                </a>

            </div>

        </form>
        
    </div>

</div>

@endsection