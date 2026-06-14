@extends('layouts.app')

@section('content')

<h2 class="text-2xl font-bold mb-6">
    Dashboard
</h2>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

    <div class="bg-white p-5 rounded shadow">
        <h3 class="text-gray-500">
            Total BSU
        </h3>

        <p class="text-3xl font-bold">
            0
        </p>
    </div>

    <div class="bg-white p-5 rounded shadow">
        <h3 class="text-gray-500">
            Total Nasabah
        </h3>

        <p class="text-3xl font-bold">
            0
        </p>
    </div>

    <div class="bg-white p-5 rounded shadow">
        <h3 class="text-gray-500">
            Total Sampah
        </h3>

        <p class="text-3xl font-bold">
            0 Kg
        </p>
    </div>

    <div class="bg-white p-5 rounded shadow">
        <h3 class="text-gray-500">
            Total Tabungan
        </h3>

        <p class="text-3xl font-bold">
            Rp 0
        </p>
    </div>

</div>

@endsection