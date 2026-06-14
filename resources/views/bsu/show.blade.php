@extends('layouts.app')

@section('content')

<div class="p-6">

    <div class="bg-white rounded-xl shadow p-6">

        <h1 class="text-2xl font-bold mb-6">
            Detail BSU
        </h1>

        <table class="w-full">

            <tr>
                <td class="font-semibold w-48">Kode BSU</td>
                <td>{{ $data->kode_bsu }}</td>
            </tr>

            <tr>
                <td class="font-semibold">Nama BSU</td>
                <td>{{ $data->nama_bsu }}</td>
            </tr>

            <tr>
                <td class="font-semibold">Ketua</td>
                <td>{{ $data->ketua }}</td>
            </tr>

            <tr>
                <td class="font-semibold">Kecamatan</td>
                <td>{{ $data->kecamatan }}</td>
            </tr>

            <tr>
                <td class="font-semibold">No HP</td>
                <td>{{ $data->no_hp }}</td>
            </tr>

            <tr>
                <td class="font-semibold">Alamat</td>
                <td>{{ $data->alamat }}</td>
            </tr>

        </table>

        <div class="mt-6">

            <a href="{{ route('bsu.index') }}"
               class="px-4 py-2 bg-gray-300 rounded-lg">

                Kembali

            </a>

        </div>

    </div>

</div>

@endsection