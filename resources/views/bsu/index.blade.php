@extends('layouts.app')

@section('content')

<div class="p-6">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Data BSU
            </h1>

            <p class="text-sm text-gray-500">
                Bank Sampah Unit
            </p>
        </div>

        <a href="{{ route('bsu.create') }}"
           class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
            + Tambah BSU
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
                    <th class="p-3 text-left">Nama BSU</th>
                    <th class="p-3 text-left">Ketua</th>
                    <th class="p-3 text-left">Kecamatan</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>

            @forelse($data as $item)

                <tr class="border-t">

                    <td class="p-3">
                        {{ $item->kode_bsu }}
                    </td>

                    <td class="p-3">
                        {{ $item->nama_bsu }}
                    </td>

                    <td class="p-3">
                        {{ $item->ketua }}
                    </td>

                    <td class="p-3">
                        {{ $item->kecamatan }}
                    </td>

                    <td class="p-3">

                        @if($item->status)
                            <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">
                                Aktif
                            </span>
                        @else
                            <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded">
                                Non Aktif
                            </span>
                        @endif

                    </td>

                    <td class="p-3 text-center">

                        <a href="{{ route('bsu.show',$item->id) }}"
                           class="bg-blue-500 text-white px-3 py-1 rounded mr-2">
                            Detail
                        </a>

                        <a href="{{ route('bsu.edit',$item->id) }}"
                           class="bg-yellow-500 text-white px-3 py-1 rounded mr-2">
                            Edit
                        </a>

                        <form
                            action="{{ route('bsu.destroy', $item->id) }}"
                            method="POST"
                            class="delete-form inline">

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="bg-red-500 text-white px-3 py-1 rounded">

                                Hapus

                            </button>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="6" class="p-4 text-center text-gray-500">
                        Belum ada data BSU
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