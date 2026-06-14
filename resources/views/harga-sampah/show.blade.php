@extends('layouts.app')

@section('content')

<div class="p-6">

    <div class="bg-white rounded-xl shadow p-6">

        <h1 class="text-2xl font-bold mb-6">
            Detail Harga Sampah
        </h1>

        <table class="w-full">

            <tr>
                <td class="font-semibold w-48">Jenis Sampah</td>
                <td>{{ $data->jenisSampah->nama }}</td>
            </tr>

            <tr>
                <td class="font-semibold">Harga/kg</td>
                <td>Rp {{ number_format($data->harga,0,',','.') }}</td>
            </tr>

            <tr>
                <td class="font-semibold">Tanggal Berlaku</td>
                <td>{{ $data->tanggal_berlaku ? \Carbon\Carbon::parse($data->tanggal_berlaku)->format('d-m-y') : '-' }}</td>
            </tr>

            <tr>
                <td class="font-semibold">Tanggal Berakhir  </td>
                <td>{{ $data->tanggal_berakhir ? \Carbon\Carbon::parse($data->tanggal_berakhir)->format('d-m-y') : '-' }}</td>
            </tr>       
        </table>

        <div class="mt-6">

            <a href="{{ route('harga-sampah.index') }}"
               class="px-4 py-2 bg-gray-300 rounded-lg">

                Kembali

            </a>

        </div>

    </div>

</div>

@endsection