@extends('layouts.app')

@section('content')

<div class="p-6">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Transaksi Setor
            </h1>
            <p class="text-sm text-gray-500">
                Daftar transaksi setor sampah
            </p>
        </div>

        <a href="{{ route('transaksi-setor.create') }}"
           class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
            + Tambah Transaksi Setor
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow overflow-hidden">

        <table class="w-full">

            <thead class="bg-gray-100">
                <tr>
                    {{-- <th class="p-3 text-left">No</th> --}}
                    <th class="p-3 text-left">Kode</th>
                    <th class="p-3 text-left">Nasabah</th>
                    <th class="p-3 text-left">Tanggal</th>
                    <th class="p-3 text-left">Total Berat</th>
                    <th class="p-3 text-left">Total Nilai</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>

            @forelse($data as $item)

                <tr class="border-t">

                    <td class="p-3">
                        {{ $item->kode_transaksi }}
                    </td>

                    <td class="p-3">
                        {{ $item->nasabah->nama ?? 'Nasabah tidak ditemukan' }}
                    </td>

                    <td class="p-3">
                        {{ $item->tanggal_transaksi ? \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d-m-Y H:i') : '-' }}
                    </td>

                    <td class="p-3">
                        {{ $item->total_berat }} Kg
                    </td>

                    <td class="p-3">
                        Rp {{ number_format($item->total_nilai, 0, ',', '.') }}
                    

                    <td class="p-3 text-center">

                        <a href="{{ route('transaksi-setor.show',$item->id) }}"
                           class="bg-blue-500 text-white px-3 py-1 rounded mr-2">
                            Detail
                        </a>

                        

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="6" class="p-4 text-center text-gray-500">
                        Belum ada data Jenis Sampah
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    <div class="mt-4">
        {{ $data->links() }}
    </div>

</div>

@endsection