@extends('layouts.app')

@section('content')

<div class="p-6">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Transaksi Penarikan
            </h1>
            <p class="text-sm text-gray-500">
                Daftar transaksi penarikan sampah
            </p>
        </div>

        <a href="{{ route('penarikan.create') }}"
           class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
            + Tambah Transaksi Penarikan
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
                    <th class="p-3 text-left">Kode</th>
                    <th class="p-3 text-left">Tanggal</th>
                    <th class="p-3 text-left">Nasabah</th>
                    <th class="p-3 text-left">Tarik</th>
                    <th class="p-3 text-left">Saldo Sesudah</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>

            @forelse($data as $item)

                <tr class="border-t">

                    <td class="p-3">
                        {{ $item->kode_penarikan }}
                    </td>

                    <td class="p-3">
                        {{ $item->tanggal_penarikan ? \Carbon\Carbon::parse($item->tanggal_penarikan)->format('d-m-Y H:i') : '-' }}
                    </td>

                    <td class="p-3">
                        {{ $item->nasabah->nama ?? 'Nasabah tidak ditemukan' }}
                    </td>
                    
                    <td class="p-3">
                        Rp {{ number_format($item->jumlah_tarik, 0, ',', '.') }}
                    </td>

                    <td class="p-3">
                        Rp {{ number_format($item->saldo_sesudah, 0, ',', '.') }}
                    </td>

                    <td class="p-3 text-center">

                        <a href="{{ route('penarikan.show',$item->id) }}"
                           class="bg-blue-500 text-white px-3 py-1 rounded mr-2">
                            Detail
                        </a>

                        

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="6" class="p-4 text-center text-gray-500">
                        Belum ada data Transaksi Penarikan
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