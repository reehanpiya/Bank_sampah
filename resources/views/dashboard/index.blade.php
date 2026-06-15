@extends('layouts.app')

@section('content')

<h2 class="text-2xl font-bold mb-6">
    Dashboard
</h2>

{{-- STATISTIC CARD --}}

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

    <div class="bg-white p-5 rounded-xl shadow">

        <h3 class="text-gray-500">
            Total BSU
        </h3>

        <p class="text-3xl font-bold text-green-600 mt-2">
            {{ $totalBsu }}
        </p>

    </div>

    <div class="bg-white p-5 rounded-xl shadow">

        <h3 class="text-gray-500">
            Total Nasabah
        </h3>

        <p class="text-3xl font-bold text-blue-600 mt-2">
            {{ $totalNasabah }}
        </p>

    </div>

    <div class="bg-white p-5 rounded-xl shadow">

        <h3 class="text-gray-500">
            Total Sampah
        </h3>

        <p class="text-3xl font-bold text-orange-600 mt-2">
            {{ number_format($totalSampah,2) }} Kg
        </p>

    </div>

    <div class="bg-white p-5 rounded-xl shadow">

        <h3 class="text-gray-500">
            Total Tabungan
        </h3>

        <p class="text-3xl font-bold text-purple-600 mt-2">
            Rp {{ number_format($totalTabungan,0,',','.') }}
        </p>

    </div>

</div>

{{-- CHART --}}

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">

    <div class="bg-white rounded-xl shadow p-6">

        <h3 class="font-semibold mb-4">
            Grafik Nilai Setoran
        </h3>

        <canvas id="setorChart"></canvas>

    </div>

    <div class="bg-white rounded-xl shadow p-6">

        <h3 class="font-semibold mb-4">
            Ringkasan Sistem
        </h3>

        <div class="space-y-4">

            <div class="flex justify-between border-b pb-2">

                <span>Total BSU</span>

                <strong>
                    {{ $totalBsu }}
                </strong>

            </div>

            <div class="flex justify-between border-b pb-2">

                <span>Total Nasabah</span>

                <strong>
                    {{ $totalNasabah }}
                </strong>

            </div>

            <div class="flex justify-between border-b pb-2">

                <span>Total Sampah</span>

                <strong>
                    {{ number_format($totalSampah,2) }} Kg
                </strong>

            </div>

            <div class="flex justify-between">

                <span>Total Tabungan</span>

                <strong>
                    Rp {{ number_format($totalTabungan,0,',','.') }}
                </strong>

            </div>

        </div>

    </div>

</div>



@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx = document.getElementById('setorChart');

new Chart(ctx, {

    type: 'bar',

    data: {

        labels: [

            @foreach($chartSetor as $item)

                'Bulan {{ $item->bulan }}',

            @endforeach

        ],

        datasets: [{

            label: 'Nilai Setoran',

            data: [

                @foreach($chartSetor as $item)

                    {{ $item->total }},

                @endforeach

            ]

        }]
    },

    options: {

        responsive: true,

        plugins: {

            legend: {

                display: true

            }

        }

    }

});

</script>

@endpush