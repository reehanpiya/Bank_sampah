@extends('layouts.app')

@section('content')

<div class="p-6">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Data Nasabah
            </h1>
            <p class="text-sm text-gray-500">
                Nasabah Bank Sampah
            </p>
        </div>

        <a href="{{ route('nasabah.create') }}"
           class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
            + Tambah Nasabah
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
                    <th class="p-3 text-left">No</th>
                    <th class="p-3 text-left">Nomor Nasabah</th>
                    <th class="p-3 text-left">Nama</th>
                    <th class="p-3 text-left">BSU</th>
                    <th class="p-3 text-left">No HP</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
            @forelse($data as $item)
                <tr class="border-t">

                    {{-- No --}}
                    <td class="p-3">
                        {{ $loop->iteration }}
                    </td>

                    {{-- Nomor Nasabah --}}
                    <td class="p-3">
                        {{ $item->nomor_nasabah }}
                    </td>

                    {{-- Nama --}}
                    <td class="p-3">
                        {{ $item->nama }}
                    </td>

                    {{-- BSU --}}
                    <td class="p-3">
                        {{ $item->bsu->nama_bsu ?? '-' }}
                    </td>

                    {{-- No HP --}}
                    <td class="p-3">
                        {{ $item->no_hp }}
                    </td>

                    {{-- Status --}}
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

                    {{-- Aksi --}}
                    <td class="p-3 text-center">
                        <a href="{{ route('nasabah.show',$item->id) }}"
                        class="bg-blue-500 text-white px-3 py-1 rounded mr-2">
                            Detail
                        </a>

                        <a href="{{ route('nasabah.edit',$item->id) }}"
                        class="bg-yellow-500 text-white px-3 py-1 rounded mr-2">
                            Edit
                        </a>

                        <form action="{{ route('nasabah.destroy', $item->id) }}"
                            method="POST"
                            class="inline delete-form">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="bg-red-500 text-white px-3 py-1 rounded">
                                Hapus
                            </button>
                        </form>
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="7" class="p-4 text-center text-gray-500">
                        Belum ada data
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