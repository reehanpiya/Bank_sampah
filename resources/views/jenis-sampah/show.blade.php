@extends('layouts.app')

@section('content')

<div class="p-6">

    <div class="bg-white rounded-xl shadow p-6">

        <h1 class="text-2xl font-bold mb-6">
            Detail Jenis Sampah
        </h1>

        <table class="w-full">

            <tr>
                <td class="font-semibold w-48">Kode Jenis Sampah</td>
                <td>{{ $data->kode }}</td>
            </tr>

            <tr>
                <td class="font-semibold">Nama Jenis Sampah</td>
                <td>{{ $data->nama }}</td>
            </tr>

            <tr>
                <td class="font-semibold">Satuan</td>
                <td>{{ $data->satuan }}</td>
            </tr>

                  
        </table>

        <div class="mt-6">

            <a href="{{ route('jenis-sampah.index') }}"
               class="px-4 py-2 bg-gray-300 rounded-lg">

                Kembali

            </a>

        </div>

    </div>

</div>

@endsection