<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.statistik.index', request()->all()) }}" 
               class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-lg transition">
                Kembali
            </a>
            <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                Grafik Statistik Absensi
            </h2>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
            <div class="mb-4 text-center">
                <h3 class="text-lg font-bold text-gray-700">Periode: {{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}</h3>
            </div>

            <div class="relative h-[500px] w-full">
                <canvas id="absensiChart"></canvas>
            </div>
        </div>

    </div>

    {{-- CHART.JS LOCAL --}}
    <script src="{{ asset('js/chart.js') }}"></script>

    <script>
        const statistikData = @json($statistik); // Data from controller

        const labels = statistikData.map(item => item.name || item.guru); // Fallback if key varies
        const dataHadir = statistikData.map(item => item.hadir);
        const dataIzin = statistikData.map(item => item.izin);
        const dataSakit = statistikData.map(item => item.sakit);
        const dataBolos = statistikData.map(item => item.bolos);

        const ctx = document.getElementById('absensiChart').getContext('2d');
        const absensiChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Hadir',
                        data: dataHadir,
                        backgroundColor: 'rgba(34, 197, 94, 0.7)', // Green-500
                        borderColor: 'rgba(34, 197, 94, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Izin',
                        data: dataIzin,
                        backgroundColor: 'rgba(59, 130, 246, 0.7)', // Blue-500
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Sakit',
                        data: dataSakit,
                        backgroundColor: 'rgba(234, 179, 8, 0.7)', // Yellow-500
                        borderColor: 'rgba(234, 179, 8, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Bolos',
                        data: dataBolos,
                        backgroundColor: 'rgba(239, 68, 68, 0.7)', // Red-500
                        borderColor: 'rgba(239, 68, 68, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Hari'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Nama Guru'
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Perbandingan Kehadiran Guru'
                    }
                }
            }
        });
    </script>
</x-app-layout>
