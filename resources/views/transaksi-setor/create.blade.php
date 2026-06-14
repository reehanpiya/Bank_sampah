@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-xl shadow p-6">

        <h1 class="text-2xl font-bold mb-6">
            Transaksi Setor Sampah
        </h1>

        <form action="{{ route('transaksi-setor.store') }}" method="POST">

            @csrf
            <div class="mb-4">

                <label class="block mb-2">
                    BSU
                </label>

                <select name="bsu_id" class="w-full border rounded-lg p-2">

                    <option value="">
                        Pilih BSU
                    </option>

                    @foreach ($bsu as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->nama_bsu }}
                        </option>
                    @endforeach

                </select>

            </div>

            <div class="mb-4">

                <label class="block mb-2">
                    Nasabah
                </label>

                <select name="nasabah_id" class="w-full border rounded-lg p-2">

                    <option value="">
                        Pilih Nasabah
                    </option>

                    @foreach ($nasabah as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->nomor_nasabah }}
                            -
                            {{ $item->nama }}
                        </option>
                    @endforeach

                </select>

            </div>

            <h3 class="font-semibold mb-3">
                Detail Sampah
            </h3>

            <div id="items-container">

                <div class="grid grid-cols-12 gap-3 mb-3 item-row">

                    <div class="col-span-5">

                        <select name="items[0][jenis_sampah_id]" class="w-full border rounded p-2">

                            @foreach ($jenisSampah as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->nama }}
                                </option>
                            @endforeach

                        </select>

                    </div>

                    <div class="col-span-3">

                        <input type="number" step="0.01" name="items[0][berat]" placeholder="Berat (Kg)"
                            class="w-full border rounded p-2">

                    </div>

                    <div class="col-span-3">

                        <button type="button" class="remove-row bg-red-500 text-white px-3 py-2 rounded">

                            Hapus

                        </button>

                    </div>

                </div>

            </div>
            <div class="flex items-center justify-between mt-6">
                <div class="flex items-center gap-3">
                    <button type="button" id="add-row" class="bg-green-600 text-white px-4 py-2 rounded">

                        + Tambah Sampah

                    </button>
                    <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded">

                        Simpan Transaksi

                    </button>
                </div>
                <a href="{{ route('transaksi-setor.index') }}"
                    class="inline-flex items-center gap-2 bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded">
                    Kembali
                </a>
            </div>

            <script>
                let index = 1;

                document
                    .getElementById('add-row')
                    .addEventListener('click', function() {

                        let html = `
    <div class="grid grid-cols-12 gap-3 mb-3 item-row">

        <div class="col-span-5">

            <select
                name="items[${index}][jenis_sampah_id]"
                class="w-full border rounded p-2">

                @foreach ($jenisSampah as $item)

                <option value="{{ $item->id }}">
                    {{ $item->nama }}
                </option>

                @endforeach

            </select>

        </div>

        <div class="col-span-3">

            <input
                type="number"
                step="0.01"
                name="items[${index}][berat]"
                placeholder="Berat (Kg)"
                class="w-full border rounded p-2">

        </div>
        <div class="col-span-3">

        <button
            type="button"
            class="remove-row bg-red-500 text-white px-3 py-2 rounded">

            Hapus

        </button>

    </div>

    </div>
    `;

                        document
                            .getElementById('items-container')
                            .insertAdjacentHTML(
                                'beforeend',
                                html
                            );

                        index++;

                    });
                document.addEventListener('click', function(e) {

                    if (e.target.classList.contains('remove-row')) {

                        e.target.closest('.item-row').remove();

                    }

                });
            </script>
        </form>
    </div>
@endsection
