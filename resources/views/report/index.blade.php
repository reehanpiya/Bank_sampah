@extends('layouts.app')

@section('content')

<div class="p-6">

    <div class="flex justify-between items-center mb-6">

        <div>
            <h1 class="text-2xl font-bold">
                Laporan Setoran Nasabah
            </h1>

            <p class="text-gray-500 text-sm">
                Data seluruh transaksi setoran sampah nasabah
            </p>
        </div>

    </div>

    {{-- FILTER --}}
    <div class="bg-white rounded-xl shadow p-4 mb-6">

        <form
            action="{{ route('laporan.index') }}"
            method="GET">

            @if(auth()->user()->role === 'admin_bsi')

                <div>

                    <label class="block mb-2 text-sm font-medium">
                        BSU
                    </label>

                    <select
                        name="bsu_id"
                        class="w-full border rounded-lg p-2">

                        <option value="">
                            Semua BSU
                        </option>

                        @foreach($bsu as $item)

                            <option
                                value="{{ $item->id }}"
                                {{ request('bsu_id') == $item->id ? 'selected' : '' }}>

                                {{ $item->nama_bsu }}

                            </option>

                        @endforeach

                    </select>

                </div>

            @endif

            <div>

                <label class="block mb-2">
                    Jenis Transaksi
                </label>

                <select
                    name="jenis_transaksi"
                    class="w-full border rounded-lg p-2">

                    <option value="">
                        Semua
                    </option>

                    <option
                        value="setoran"
                        {{ request('jenis_transaksi') == 'setoran' ? 'selected' : '' }}>
                        Setoran
                    </option>

                    <option
                        value="penarikan"
                        {{ request('jenis_transaksi') == 'penarikan' ? 'selected' : '' }}>
                        Penarikan
                    </option>

                </select>

            </div>

            <div>

                <label class="block mb-2 text-sm font-medium">
                    Nasabah
                </label>

                <select
                    name="nasabah_id"
                    class="w-full border rounded-lg p-2">

                    <option value="">
                        Semua Nasabah
                    </option>

                    @foreach($nasabah as $item)

                        <option
                            value="{{ $item->id }}"
                            {{ request('nasabah_id') == $item->id ? 'selected' : '' }}>

                            {{ $item->nama }}

                        </option>

                    @endforeach

                </select>

            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                
                <div>
                    
                    <label class="block mb-2 text-sm font-medium">
                        Tanggal Awal
                    </label>
                    
                    <input
                    type="date"
                    name="tanggal_awal"
                    value="{{ request('tanggal_awal') }}"
                    class="w-full border rounded-lg p-2">
                    
                </div>
                
                <div>
                    
                    <label class="block mb-2 text-sm font-medium">
                        Tanggal Akhir
                    </label>
                    
                    <input
                        type="date"
                        name="tanggal_akhir"
                        value="{{ request('tanggal_akhir') }}"
                        class="w-full border rounded-lg p-2">

                </div>

                

                <div class="mb-4 flex gap-2">

                    <a
                        href="{{ route('laporan.export-csv', request()->query()) }}"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg">

                        Export CSV

                    </a>

                    <a
                        href="{{ route('laporan.export-excel', request()->query()) }}"
                        class="bg-emerald-700 text-white px-4 py-2 rounded-lg">

                        Export Excel

                    </a>

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

    </div>
    <div class="grid grid-cols-3 gap-4 mb-6">

    <div class="bg-green-100 p-4 rounded-lg">

        <h3 class="text-sm text-gray-600">
            Total Setoran
        </h3>

        <p class="text-2xl font-bold text-green-700">
            Rp {{ number_format($totalSetoran,0,',','.') }}
        </p>

    </div>

    <div class="bg-red-100 p-4 rounded-lg">

            <h3 class="text-sm text-gray-600">
                Total Penarikan
            </h3>

            <p class="text-2xl font-bold text-red-700">
                Rp {{ number_format($totalPenarikan,0,',','.') }}
            </p>

        </div>

        <div class="bg-blue-100 p-4 rounded-lg">

            <h3 class="text-sm text-gray-600">
                Saldo Bersih
            </h3>

            <p class="text-2xl font-bold text-blue-700">
                Rp {{ number_format($totalSetoran - $totalPenarikan,0,',','.') }}
            </p>

        </div>

    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <table class="w-full">

            <thead class="bg-gray-100">

                <tr>

                    <th class="p-3 text-left">
                        No
                    </th>

                    <th class="p-3 text-left">
                        Tanggal
                    </th>

                    <th class="p-3 text-left">
                        Kode Transaksi
                    </th>

                    <th class="p-3 text-left">
                        BSU
                    </th>

                    <th class="p-3 text-left">
                        Nasabah
                    </th>

                    <th class="p-3 text-right">
                        Berat (Kg)
                    </th>

                    <th class="p-3 text-right">
                        Nilai (Rp)
                    </th>

                    <th class="p-3 text-center">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($data as $item)

                    <tr class="border-t">

                        <td class="p-3">
                            {{ $loop->iteration }}
                        </td>

                        <td class="p-3">
                            {{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d-m-Y') }}
                        </td>

                        <td class="p-3">
                            {{ $item->kode_transaksi }}
                        </td>

                        <td class="p-3">
                            {{ $item->bsu->nama_bsu ?? '-' }}
                        </td>

                        <td class="p-3">
                            {{ $item->nasabah->nama ?? '-' }}
                        </td>

                        <td class="p-3 text-right">
                            {{ number_format($item->total_berat, 2, ',', '.') }}
                        </td>

                        <td class="p-3 text-right">
                            Rp {{ number_format($item->total_nilai, 0, ',', '.') }}
                        </td>

                        <td class="p-3 text-center">

                            <a
                                href="{{ route('report.show', $item->id) }}"
                                class="bg-blue-500 text-white px-3 py-1 rounded">

                                Detail

                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="8"
                            class="p-6 text-center text-gray-500">

                            Belum ada data transaksi

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    {{-- PAGINATION --}}
    <div class="mt-4">

        {{ $data->links() }}

    </div>

</div>

@endsection