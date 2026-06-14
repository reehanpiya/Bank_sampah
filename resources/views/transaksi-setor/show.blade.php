@extends('layouts.app')

@section('content')

<div class="bg-white rounded-xl shadow p-6">

    <div class="flex justify-between items-center mb-6">

        <h1 class="text-2xl font-bold">
            Detail Transaksi Setor
        </h1>

        <a
            href="{{ route('transaksi-setor.index') }}"
            class="bg-gray-500 text-white px-4 py-2 rounded-lg">

            Kembali

        </a>

    </div>

    <div class="grid md:grid-cols-2 gap-6 mb-6">

        <div>

            <p class="mb-2">
                <strong>Kode Transaksi :</strong>
                {{ $data->kode_transaksi }}
            </p>

            <p class="mb-2">
                <strong>Tanggal :</strong>
                {{ \Carbon\Carbon::parse($data->tanggal_transaksi)->format('d-m-Y H:i') }}
            </p>

            <p class="mb-2">
                <strong>Status :</strong>

                <span class="bg-green-100 text-green-700 px-2 py-1 rounded">
                    {{ ucfirst($data->status) }}
                </span>
            </p>

        </div>

        <div>

            <p class="mb-2">
                <strong>BSU :</strong>
                {{ $data->bsu->nama_bsu }}
            </p>

            <p class="mb-2">
                <strong>Nasabah :</strong>
                {{ $data->nasabah->nama }}
            </p>

            <p class="mb-2">
                <strong>No Nasabah :</strong>
                {{ $data->nasabah->nomor_nasabah }}
            </p>

        </div>

    </div>

    <hr class="my-6">

    <h2 class="text-lg font-semibold mb-4">
        Detail Sampah
    </h2>

    <div class="bg-white rounded-xl shadow overflow-hidden">

        <table class="w-full">

            <thead class="bg-gray-100">
                <tr>
                    {{-- <th class="p-3 text-left">No</th> --}}
                    <th class="p-3 text-left">No</th>
                    <th class="p-3 text-left">Jenis Sampah</th>
                    <th class="p-3 text-left">Berat (Kg)</th>
                    <th class="p-3 text-left">Harga/Kg</th>
                    <th class="p-3 text-left">subtotal</th>
                </tr>
            </thead>

            <tbody>

            @forelse($data->details as $index => $item)

                <tr class="border-t">
                    <td class="p-3">
                    {{ $index + 1 }}
                </td>

                    <td class="p-3">
                        {{ $item->jenisSampah->kode ?? '-' }}
                    </td>

                    <td class="p-3">
                        {{number_format($item->berat, 2, ',', '.')}} {{ $item->jenisSampah->satuan ?? '-' }}
                    </td>

                    <td class="p-3">
                        {{ 'Rp ' . number_format($item->harga_satuan, 0, ',', '.') }}
                    </td>

                    <td class="p-3">
                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                    
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="6" class="p-4 text-center text-gray-500">
                        Belum ada data Transaksi Setor
                    </td>
                </tr>

            @endforelse

            </tbody>
            <tfoot>

            <tr class="bg-gray-200 font-semibold">

                <td colspan="2" class=" p-3">
                    TOTAL
                </td>

                <td class=" p-3 ">
                    {{ number_format($data->total_berat,2) }}
                </td>

                <td class=" p-3"></td>

                <td class=" p-3">
                    Rp {{ number_format($data->total_nilai,0,',','.') }}
                </td>

            </tr>

        </tfoot>

        </table>

    </div>

</div>

@endsection