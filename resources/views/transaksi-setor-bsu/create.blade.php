@extends('layouts.app')

@section('content')



<div class="bg-white p-6 rounded-lg shadow">

    <h1 class="text-2xl font-bold mb-6">
        Setor Sampah BSU ke BSI
    </h1>

    <form
        action="{{ route('transaksi-setor-bsu.store') }}"
        method="POST">

        @csrf

        {{-- BSU --}}
        <div class="mb-4">

            <label class="block mb-2 font-medium">
                BSU
            </label>

            <select
                name="bsu_id"
                class="w-full border rounded-lg p-2"
                required>

                <option value="">
                    Pilih BSU
                </option>

                @foreach($bsu as $item)

                    <option
                        value="{{ $item->id }}"
                        {{ old('bsu_id') == $item->id ? 'selected' : '' }}>

                        {{ $item->nama_bsu }}

                    </option>

                @endforeach

            </select>

            @error('bsu_id')
                <small class="text-red-500">
                    {{ $message }}
                </small>
            @enderror

        </div>

        {{-- DETAIL --}}
        <h3 class="font-semibold mb-3">
            Detail Sampah
        </h3>

        <div id="items-container">

            <div class="grid grid-cols-12 gap-3 mb-3 item-row">

                <div class="col-span-5">

                    <select
                        name="items[0][jenis_sampah_id]"
                        class="w-full border rounded p-2">

                        @foreach($jenisSampah as $item)

                            <option value="{{ $item->id }}">
                                {{ $item->nama }}
                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-span-5">

                    <input
                        type="number"
                        step="0.01"
                        name="items[0][berat]"
                        placeholder="Berat (Kg)"
                        class="w-full border rounded p-2">

                </div>

                <div class="col-span-2">

                    <button
                        type="button"
                        class="remove-row bg-red-500 text-white px-3 py-2 rounded w-full">

                        Hapus

                    </button>

                </div>

            </div>

        </div>

        <button
            type="button"
            id="add-row"
            class="bg-blue-500 text-white px-4 py-2 rounded mb-4">

            + Tambah Item

        </button>

        {{-- KETERANGAN --}}
        <div class="mb-4">

            <label class="block mb-2">
                Keterangan
            </label>

            <textarea
                name="keterangan"
                rows="3"
                class="w-full border rounded-lg p-2">{{ old('keterangan') }}</textarea>

        </div>

        <button
            type="submit"
            class="bg-green-600 text-white px-5 py-2 rounded">

            Simpan Transaksi

        </button>

    </form>

</div>

<script>

let index = 1;

document
    .getElementById('add-row')
    .addEventListener('click', function () {

        const container =
            document.getElementById(
                'items-container'
            );

        const html = `
            <div class="grid grid-cols-12 gap-3 mb-3 item-row">

                <div class="col-span-5">

                    <select
                        name="items[${index}][jenis_sampah_id]"
                        class="w-full border rounded p-2">

                        @foreach($jenisSampah as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->nama }}
                            </option>
                        @endforeach

                    </select>

                </div>

                <div class="col-span-5">

                    <input
                        type="number"
                        step="0.01"
                        name="items[${index}][berat]"
                        placeholder="Berat (Kg)"
                        class="w-full border rounded p-2">

                </div>

                <div class="col-span-2">

                    <button
                        type="button"
                        class="remove-row bg-red-500 text-white px-3 py-2 rounded w-full">

                        Hapus

                    </button>

                </div>

            </div>
        `;

        container.insertAdjacentHTML(
            'beforeend',
            html
        );

        index++;
    });

document.addEventListener(
    'click',
    function (e) {

        if (
            e.target.classList.contains(
                'remove-row'
            )
        ) {

            e.target
                .closest('.item-row')
                .remove();
        }
    }
);

</script>

@endsection