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

    <form action="{{ route('laporan.index') }}" method="GET">

        @if(auth()->user()->role === 'admin_bsi')
            <div class="mb-4">
                <label class="block mb-2 text-sm font-medium">BSU</label>
                <select id="bsu_id" name="bsu_id" class="w-full border rounded-lg p-2">
                    <option value="">Semua BSU</option>
                    @foreach($bsu as $item)
                        <option value="{{ $item->id }}">{{ $item->nama_bsu }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        <div class="mb-4">
            <label class="block mb-2 text-sm font-medium">Nasabah</label>
            <select
    id="nasabah_id"
    name="nasabah_id"
    class="w-full border rounded-lg p-2">

    <option value="">
        Semua Nasabah
    </option>

    @foreach($nasabah as $item)
        <option value="{{ $item->id }}">
            {{ $item->nama }}
        </option>
    @endforeach

</select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block mb-2 text-sm font-medium">Tanggal Awal</label>
                <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}" 
                       class="w-full border rounded-lg p-2">
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium">Tanggal Akhir</label>
                <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" 
                       class="w-full border rounded-lg p-2">
            </div>
        </div>

        <!-- Baris tombol -->
        <div class="flex flex-col sm:flex-row justify-between items-end gap-4">
            
            <!-- Kiri: Filter & Reset -->
            <div class="flex items-center gap-3">
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg transition">
                    Filter
                </button>
                
                <a href="{{ route('laporan.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2.5 rounded-lg transition">
                    Reset
                </a>
            </div>

            <!-- Kanan: Export CSV & Excel -->
            <div class="flex items-center gap-3">
                <a href="{{ route('laporan.export-csv', request()->query()) }}" 
                   class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg transition flex items-center gap-2">
                    Export CSV
                </a>
                
                <a href="{{ route('laporan.export-excel', request()->query()) }}" 
                   class="bg-emerald-700 hover:bg-emerald-800 text-white px-5 py-2.5 rounded-lg transition flex items-center gap-2">
                    Export Excel
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

    <div class="flex gap-2 mb-4">

        <a
            href="{{ route('laporan.index', array_merge(request()->except('page'), ['jenis' => 'setoran'])) }}"
            class="{{ request('jenis', 'setoran') == 'setoran'
                ? 'bg-blue-600 text-white'
                : 'bg-gray-200' }}
                px-4 py-2 rounded">

            Setoran

        </a>

        <a
            href="{{ route('laporan.index', array_merge(request()->except('page'), ['jenis' => 'penarikan'])) }}"
            class="{{ request('jenis') == 'penarikan'
                ? 'bg-red-600 text-white'
                : 'bg-gray-200' }}
                px-4 py-2 rounded">

            Penarikan

        </a>

    </div>

    {{-- TABLE SETORAN --}}
@if(request('jenis') != 'penarikan')




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
                    Kode Penarikan
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
@endif

{{-- TABLE PENARIKAN --}}
@if(request('jenis') == 'penarikan')

<div class="bg-white rounded-xl shadow overflow-hidden">

    <table class="w-full">

        <thead class="bg-gray-100">
            <tr>
                <th class="p-3 text-left">No</th>
                <th class="p-3 text-left">Tanggal</th>
                <th class="p-3 text-left">Kode Penarikan</th>
                <th class="p-3 text-left">BSU</th>
                <th class="p-3 text-left">Nasabah</th>
                <th class="p-3 text-right">Jumlah Tarik</th>
                <th class="p-3 text-center">Aksi</th>
            </tr>
        </thead>

        <tbody>

            @forelse($data as $item)

                <tr class="border-t">

                    <td class="p-3">
                        {{ $loop->iteration }}
                    </td>

                    <td class="p-3">
                        {{ $item->tanggal_penarikan->format('d-m-Y') }}
                    </td>

                    <td class="p-3">
                        {{ $item->kode_penarikan }}
                    </td>

                    <td class="p-3">
                        {{ $item->bsu->nama_bsu ?? '-' }}
                    </td>

                    <td class="p-3">
                        {{ $item->nasabah->nama ?? '-' }}
                    </td>

                    <td class="p-3 text-right">
                        Rp {{ number_format($item->jumlah_tarik,0,',','.') }}
                    </td>

                    <td class="p-3 text-center">

                        <a
                            href="{{ route('report.show-penarikan', $item->id) }}"
                            class="bg-blue-500 text-white px-3 py-1 rounded">

                            Detail

                        </a>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="7" class="p-6 text-center text-gray-500">
                        Belum ada data penarikan
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endif
    

    {{-- PAGINATION --}}
    <div class="mt-4">

        {{ $data->links() }}

    </div>

</div>


<script>

    console.log('Nasabah:', @json($nasabah));

let bsuSelect = document.getElementById('bsu_id');

if (bsuSelect) {

    bsuSelect.addEventListener('change', function() {

        let bsuId = this.value;

        fetch('/api/nasabah/' + bsuId)

        .then(response => response.json())

        .then(data => {

            let nasabah =
                document.getElementById('nasabah_id');

            nasabah.innerHTML =
                '<option value="">Semua Nasabah</option>';

            data.forEach(item => {

                nasabah.innerHTML += `
                    <option value="${item.id}">
                        ${item.nama}
                    </option>
                `;
            });

        });

    });

}

</script>

@endsection

