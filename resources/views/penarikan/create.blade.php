@extends('layouts.app')

@section('content')

<div class="bg-white rounded-xl shadow p-6">

    <h1 class="text-2xl font-bold mb-6">
        Penarikan Saldo
    </h1>

    <form
        action="{{ route('penarikan.store') }}"
        method="POST">

        @csrf

        <div class="mb-4">

            <label class="block mb-2">
                BSU
            </label>

            <select
                name="bsu_id"
                class="w-full border rounded-lg p-2">

                <option value="">
                    Pilih BSU
                </option>

                @foreach($bsu as $item)

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

            <select
                name="nasabah_id"
                class="w-full border rounded-lg p-2">

                <option value="">
                    Pilih Nasabah
                </option>

                @foreach($nasabah as $item)

                <option value="{{ $item->id }}">
                    {{ $item->nomor_nasabah }}
                    -
                    {{ $item->nama }}
                </option>

                @endforeach

            </select>

        </div>

        <div class="mb-4">

            <label class="block mb-2">
                Jumlah Tarik
            </label>

            <input
                type="number"
                name="jumlah_tarik"
                class="w-full border rounded-lg p-2">

        </div>

        <div class="mb-4">

            <label class="block mb-2">
                Keterangan
            </label>

            <textarea
                name="keterangan"
                rows="3"
                class="w-full border rounded-lg p-2"></textarea>

        </div>

        <button
            type="submit"
            class="bg-blue-600 text-white px-5 py-2 rounded-lg">

            Simpan

        </button>

    </form>

</div>

@endsection