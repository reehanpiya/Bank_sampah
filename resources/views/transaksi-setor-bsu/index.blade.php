@extends('layouts.app')

@section('content')

<div class="bg-white p-6 rounded-lg shadow">

    <div class="flex justify-between items-center mb-6">

        <h1 class="text-2xl font-bold">
            Transaksi Setor BSU
        </h1>

        <a
            href="{{ route('transaksi-setor-bsu.create') }}"
            class="bg-green-600 text-white px-4 py-2 rounded">

            + Transaksi Baru

        </a>

    </div>

    @if(session('success'))

        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>

    @endif

    <div class="overflow-x-auto">

        <table class="w-full border-collapse border">

            <thead>

                <tr class="bg-gray-100">

                    <th class="border p-2">
                        Kode
                    </th>

                    <th class="border p-2">
                        BSU
                    </th>

                    <th class="border p-2">
                        Tanggal
                    </th>

                    <th class="border p-2">
                        Berat
                    </th>

                    <th class="border p-2">
                        Nilai
                    </th>

                    <th class="border p-2">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($transaksi as $item)

                    <tr>

                        <td class="border p-2">
                            {{ $item->kode_transaksi }}
                        </td>

                        <td class="border p-2">
                            {{ $item->bsu->nama_bsu ?? '-' }}
                        </td>

                        <td class="border p-2">
                            {{ $item->tanggal_transaksi }}
                        </td>

                        <td class="border p-2 text-right">
                            {{ number_format($item->total_berat, 2) }}
                        </td>

                        <td class="border p-2 text-right">
                            Rp {{ number_format($item->total_nilai, 0, ',', '.') }}
                        </td>

                        <td class="border p-2">

                            <a
                                href="{{ route('transaksi-setor-bsu.show', $item->id) }}"
                                class="text-blue-600">

                                Detail

                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="6"
                            class="border p-4 text-center">

                            Belum ada transaksi

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="mt-4">

        {{ $transaksi->links() }}

    </div>

</div>

@endsection