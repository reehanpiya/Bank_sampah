@extends('layouts.app')

@section('content')

<div class="bg-white p-6 rounded-lg shadow">

    <div class="flex justify-between items-center mb-6">

        <h1 class="text-2xl font-bold">
            Detail Transaksi BSU
        </h1>

        <a
            href="{{ route('transaksi-setor-bsu.index') }}"
            class="bg-gray-500 text-white px-4 py-2 rounded">

            Kembali

        </a>

    </div>

    <div class="grid grid-cols-2 gap-4 mb-6">

        <div>

            <label class="font-semibold">
                Kode Transaksi
            </label>

            <p>
                {{ $transaksi->kode_transaksi }}
            </p>

        </div>

        <div>

            <label class="font-semibold">
                Tanggal
            </label>

            <p>
                {{ $transaksi->tanggal_transaksi }}
            </p>

        </div>

        <div>

            <label class="font-semibold">
                BSU
            </label>

            <p>
                {{ $transaksi->bsu->nama_bsu }}
            </p>

        </div>

        <div>

            <label class="font-semibold">
                Status
            </label>

            <p>
                {{ strtoupper($transaksi->status) }}
            </p>

        </div>

    </div>

    <h3 class="font-semibold mb-3">
        Detail Sampah
    </h3>

    <table class="w-full border-collapse border mb-6">

        <thead>

            <tr class="bg-gray-100">

                <th class="border p-2">
                    Jenis Sampah
                </th>

                <th class="border p-2">
                    Berat
                </th>

                <th class="border p-2">
                    Harga
                </th>

                <th class="border p-2">
                    Subtotal
                </th>

            </tr>

        </thead>

        <tbody>

            @foreach($transaksi->details as $detail)

                <tr>

                    <td class="border p-2">
                        {{ $detail->jenisSampah->nama }}
                    </td>

                    <td class="border p-2 text-right">
                        {{ number_format($detail->berat, 2) }}
                    </td>

                    <td class="border p-2 text-right">
                        Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}
                    </td>

                    <td class="border p-2 text-right">
                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

    <div class="flex justify-end">

        <div class="w-80">

            <div class="flex justify-between mb-2">

                <span>Total Berat</span>

                <span>
                    {{ number_format($transaksi->total_berat, 2) }} Kg
                </span>

            </div>

            <div class="flex justify-between font-bold text-lg">

                <span>Total Nilai</span>

                <span>
                    Rp {{ number_format($transaksi->total_nilai, 0, ',', '.') }}
                </span>

            </div>

        </div>

    </div>

</div>

@endsection