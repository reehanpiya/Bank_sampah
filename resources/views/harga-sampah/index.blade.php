@extends('layouts.app')

@section('content')

<div class="p-6">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Data Harga Sampah
            </h1>
            <p class="text-sm text-gray-500">
                Harga-harga sampah berdasarkan jenis sampah
            </p>
        </div>

        @if(auth()->user()->role == 'admin_bsi')
            <a href="{{ route('harga-sampah.create') }}"
            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                + Tambah Harga Sampah
            </a>
        @endif
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
                    <th class="p-3 text-left">Jenis Sampah</th>
                    <th class="p-3 text-left">Harga/kg</th>
                    <th class="p-3 text-left">Tanggal Berlaku</th>
                    <th class="p-3 text-left">Tanggal Berakhir</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>

            @forelse($data as $item)

                <tr class="border-t">

                    <td class="p-3">
                        {{ $item->jenisSampah->nama??'-' }}
                    </td>

                    <td class="p-3">
                        Rp {{ number_format($item->harga,0,',','.') }}
                    </td>

                    <td class="p-3">
                        {{ $item->tanggal_berlaku ? \Carbon\Carbon::parse($item->tanggal_berlaku)->format('d-m-y') : '-' }}
                    </td>

                    <td class="p-3">
                        {{ $item->tanggal_berakhir ? \Carbon\Carbon::parse($item->tanggal_berakhir)->format('d-m-y') : '-' }}
                    </td>

                    <td class="p-3">

                        @if($item->status_aktif)
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

                        <a href="{{ route('harga-sampah.show',$item->id) }}"
                        class="bg-blue-500 text-white px-3 py-1 rounded mr-2">
                            Detail
                        </a>

                        @if(auth()->user()->role == 'admin_bsi')

                            <a href="{{ route('harga-sampah.edit',$item->id) }}"
                            class="bg-yellow-500 text-white px-3 py-1 rounded mr-2">
                                Edit
                            </a>

                            <form
                                action="{{ route('harga-sampah.destroy', $item->id) }}"
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

                        @endif

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="6" class="p-4 text-center text-gray-500">
                        Belum ada data Harga Sampah
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