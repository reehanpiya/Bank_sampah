@extends('layouts.app')

@section('content')

<div class="p-6">

    <div class="bg-white rounded-xl shadow p-6">

        <h1 class="text-2xl font-bold mb-6">
            Detail Nasabah
        </h1>

        <table class="w-full">

            <tr>
                <td class="font-semibold w-48">Nomor Nasabah</td>
                <td>{{ $data->nomor_nasabah }}</td>
            </tr>

            <tr>
                <td class="font-semibold">Nama Nasabah</td>
                <td>{{ $data->nama }}</td>
            </tr>

            <tr>
                <td class="font-semibold">BSU</td>
                <td>{{ $data->bsu->nama_bsu ?? '-' }}</td>
            </tr>

            <tr>
                <td class="font-semibold">Alamat</td>
                <td>{{ $data->alamat }}</td>
            </tr>

            <tr>
                <td class="font-semibold">No HP</td>
                <td>{{ $data->no_hp }}</td>
            </tr>

            <tr>
                <td class="font-semibold">NIK</td>
                <td>{{ $data->nik }}</td>
            </tr>

        </table>

        <div class="mt-6">

            <a href="{{ route('nasabah.index') }}"
               class="px-4 py-2 bg-gray-300 rounded-lg">

                Kembali

            </a>

        </div>

    </div>

</div>

@endsection