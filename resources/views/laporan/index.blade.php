@extends('layouts.app')

@section('content')

<div class="bg-white rounded-xl shadow p-6">

    <div class="flex justify-between items-center mb-6">

        <h1 class="text-2xl font-bold">
            Laporan Sampah Masuk
        </h1>

    </div>

    <div class="overflow-x-auto">
        <form
    method="GET"
    action="{{ route('laporan.index') }}"
    class="mb-6">

    <div class="grid grid-cols-3 gap-4">

        <div>

            <label class="block mb-2">
                Tanggal Awal
            </label>

            <input
                type="date"
                name="tanggal_awal"
                value="{{ request('tanggal_awal') }}"
                class="w-full border rounded-lg p-2">

        </div>

        <div>

            <label class="block mb-2">
                Tanggal Akhir
            </label>

            <input
                type="date"
                name="tanggal_akhir"
                value="{{ request('tanggal_akhir') }}"
                class="w-full border rounded-lg p-2">

        </div>

        <div class="flex items-end gap-2">

            <button
                type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg">

                Filter

            </button>

            <a
                href="{{ route('laporan.index') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded-lg">

                Reset

            </a>

        </div>

    </div>

</form>

        <table class="w-full border">

            <thead>

                <tr class="bg-gray-100">

                    <th class="border p-2">No</th>
                    <th class="border p-2">BSU</th>
                    <th class="border p-2">Tanggal</th>
                    <th class="border p-2">Kode Transaksi</th>
                    <th class="border p-2">Jenis Sampah</th>
                    <th class="border p-2">Jumlah (Kg)</th>
                    <th class="border p-2">Nilai (Rp)</th>

                </tr>

            </thead>

            <tbody>

                @forelse($data as $index => $item)

                <tr>

                    <td class="border p-2 text-center">
                        {{ $index + 1 }}
                    </td>

                    <td class="border p-2">
                        {{ $item->transaksiSetor->bsu->nama_bsu ?? '-' }}
                    </td>

                    <td class="border p-2">
                        {{ \Carbon\Carbon::parse($item->transaksiSetor->tanggal_transaksi)->format('d-m-Y') }}
                    </td>

                    <td class="border p-2">
                        {{ $item->transaksiSetor->kode_transaksi }}
                    </td>

                    <td class="border p-2">
                        {{ $item->jenisSampah->nama }}
                    </td>

                    <td class="border p-2 text-right">
                        {{ number_format($item->berat,2,',','.') }}
                    </td>

                    <td class="border p-2 text-right">
                        Rp {{ number_format($item->subtotal,0,',','.') }}
                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="7"
                        class="border p-4 text-center">

                        Belum ada data

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection