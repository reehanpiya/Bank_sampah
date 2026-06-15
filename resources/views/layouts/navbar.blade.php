<nav class="bg-white border-b border-slate-200">

    <div class="h-20 px-6 flex items-center justify-between">

        <div>

            <h2 class="font-semibold text-slate-800">
                Sistem Informasi Bank Sampah
            </h2>

            <p class="text-sm text-slate-500">
                Bank Sampah Indonesia
            </p>

        </div>

        <div class="flex items-center gap-4">

            <div class="text-right">

                <p class="font-medium text-slate-700">
                    {{ Auth::user()->name }}
                </p>

                <p class="text-xs text-green-600">
                    Online
                </p>

            </div>

            <div
                class="w-10 h-10 rounded-full bg-green-600 text-white flex items-center justify-center font-semibold">

                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}

            </div>

        </div>

    </div>

</nav>