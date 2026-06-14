@extends('layouts.app')

@section('content')

<div class="p-6 max-w-4xl mx-auto">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Tambah Harga Sampah
        </h1>

        <p class="text-sm text-gray-500">
            Form tambah harga sampah berdasarkan jenis sampah
        </p>
    </div>

    <div class="bg-white rounded-xl shadow p-6">

        <form action="{{ route('harga-sampah.store') }}" method="POST">

            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block mb-2 text-sm font-medium">
                        Jenis Sampah
                    </label>

                    <select
                        name="jenis_sampah_id"
                        class="w-full border rounded-lg px-3 py-2">

                        <option value="">
                            Pilih Jenis Sampah 
                        </option>

                        @foreach($jenisSampah as $item)

                            <option
                                value="{{ $item->id }}"
                                {{ old('jenis_sampah_id') == $item->id ? 'selected' : '' }}>

                                {{ $item->nama }}

                            </option>

                        @endforeach

                    </select>

                    @error('jenis_sampah_id')
                        <small class="text-red-500">
                            {{ $message }}
                        </small>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium">
                        Harga per kg
                    </label>

                    <input
                        type="text"
                        name="harga"
                        value="{{ old('harga') }}"
                        class="w-full border rounded-lg px-3 py-2">

                    @error('harga')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium">
                        Tanggal Berlaku
                    </label>

                    <input
                        type="date"
                        name="tanggal_berlaku"
                        value="{{ old('tanggal_berlaku') }}"
                        class="w-full border rounded-lg px-3 py-2">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium">
                        Tanggal Berakhir
                    </label>

                    <input
                        type="date"
                        name="tanggal_berakhir"
                        value="{{ old('tanggal_berakhir') }}"
                        class="w-full border rounded-lg px-3 py-2">

                    @error('tanggal_berakhir')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>

            </div>
          
            <div class="mt-6 flex gap-3">

                <button
                    type="submit"
                    class="px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">

                    Simpan

                </button>

                <a href="{{ route('harga-sampah.index') }}"
                   class="px-5 py-2 bg-gray-300 rounded-lg">

                    Kembali

                </a>

            </div>

        </form>
        
    </div>

</div>

@endsection