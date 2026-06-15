<aside class="w-64 bg-green-700 text-white min-h-screen">

    <div class="p-4 border-b border-green-600">
        <h1 class="text-xl font-bold">
            Bank Sampah
        </h1>
    </div>

    <nav class="p-4">

        <ul class="space-y-2">

            <li>
                <a href="/" class="block px-3 py-2 rounded hover:bg-green-600">
                    Dashboard
                </a>
            </li>

            {{-- MENU KHUSUS BSI --}}
            @if(auth()->user()->role == 'admin_bsi')

                <li>
                    <a href="{{ route('bsu.index') }}"
                       class="block px-3 py-2 rounded hover:bg-green-600">
                        Data BSU
                    </a>
                </li>

                <li>
                    <a href="{{ route('jenis-sampah.index') }}"
                       class="block px-3 py-2 rounded hover:bg-green-600">
                        Jenis Sampah
                    </a>
                </li>

                <li>
                    <a href="{{ route('harga-sampah.index') }}"
                       class="block px-3 py-2 rounded hover:bg-green-600">
                        Harga Sampah
                    </a>
                </li>

                <li>
                    <a href="{{ route('transaksi-setor-bsu.index') }}"
                       class="block px-3 py-2 rounded hover:bg-green-600">
                        Setor BSU
                    </a>
                </li>

            @endif


            {{-- MENU KHUSUS BSU --}}
            @if(auth()->user()->role == 'admin_bsu')

                <li>
                    <a href="{{ route('nasabah.index') }}"
                       class="block px-3 py-2 rounded hover:bg-green-600">
                        Nasabah
                    </a>
                </li>

                <li>
                    <a href="{{ route('jenis-sampah.index') }}"
                       class="block px-3 py-2 rounded hover:bg-green-600">
                        Jenis Sampah
                    </a>
                </li>

                <li>
                    <a href="{{ route('harga-sampah.index') }}"
                       class="block px-3 py-2 rounded hover:bg-green-600">
                        Harga Sampah
                    </a>
                </li>

                <li>
                    <a href="{{ route('transaksi-setor.index') }}"
                       class="block px-3 py-2 rounded hover:bg-green-600">
                        Setor Sampah
                    </a>
                </li>

                <li>
                    <a href="{{ route('penarikan.index') }}"
                       class="block px-3 py-2 rounded hover:bg-green-600">
                        Penarikan
                    </a>
                </li>

            @endif

            {{-- SAMA UNTUK SEMUA ROLE --}}
            <li>
                <a href="{{ route('laporan.index') }}"
                   class="block px-3 py-2 rounded hover:bg-green-600">
                    Laporan
                </a>
            </li>

        </ul>

    </nav>

</aside>