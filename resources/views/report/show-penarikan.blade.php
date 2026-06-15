@extends('layouts.app')

@section('content')

<div class="bg-white rounded-xl shadow p-6">

    <div class="flex justify-between items-center mb-6">

        <h1 class="text-2xl font-bold">
            Detail Penarikan
        </h1>

        <a
            href="{{ route('laporan.index', ['jenis' => 'penarikan']) }}"
            class="bg-gray-500 text-white px-4 py-2 rounded-lg">

            Kembali

        </a>

    </div>

    <div class="grid md:grid-cols-2 gap-6 mb-6">

        <div>

            <p class="mb-2">
                <strong>Kode Penarikan :</strong>
                {{ $penarikan->kode_penarikan }}
            </p>

            <p class="mb-2">
                <strong>Tanggal :</strong>
                {{ \Carbon\Carbon::parse($penarikan->tanggal_penarikan)->format('d-m-Y H:i') }}
            </p>

            <p class="mb-2">
                <strong>Status :</strong>

                <span class="px-2 py-1 rounded bg-green-100 text-green-700">
                    {{ ucfirst($penarikan->status) }}
                </span>

            </p>

        </div>

        <div>

            <p class="mb-2">
                <strong>BSU :</strong>
                {{ $penarikan->bsu?->nama_bsu ?? '-' }}
            </p>

            <p class="mb-2">
                <strong>Nasabah :</strong>
                {{ $penarikan->nasabah?->nama ?? '-' }}
            </p>

            <p class="mb-2">
                <strong>No Nasabah :</strong>
                {{ $penarikan->nasabah?->nomor_nasabah ?? '-' }}
            </p>

        </div>

    </div>

    <hr class="my-6">

    <div class="grid md:grid-cols-3 gap-4">

        <div class="border rounded-lg p-4">

            <p class="text-sm text-gray-500">
                Saldo Sebelum
            </p>

            <h3 class="text-xl font-bold">
                Rp {{ number_format($penarikan->saldo_sebelum,0,',','.') }}
            </h3>

        </div>

        <div class="border rounded-lg p-4">

            <p class="text-sm text-gray-500">
                Jumlah Tarik
            </p>

            <h3 class="text-xl font-bold text-red-600">
                Rp {{ number_format($penarikan->jumlah_tarik,0,',','.') }}
            </h3>

        </div>

        <div class="border rounded-lg p-4">

            <p class="text-sm text-gray-500">
                Saldo Sesudah
            </p>

            <h3 class="text-xl font-bold text-green-600">
                Rp {{ number_format($penarikan->saldo_sesudah,0,',','.') }}
            </h3>

        </div>

    </div>

    @if($penarikan->keterangan)

    <div class="mt-6">

        <h3 class="font-semibold mb-2">
            Keterangan
        </h3>

        <p>
            {{ $penarikan->keterangan }}
        </p>

    </div>

    @endif

</div>

@endsection