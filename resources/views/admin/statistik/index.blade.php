<x-app-layout>
    <div class="py-12 px-6">
        <div class="max-w-7xl mx-auto">
            
            {{-- Header --}}
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800">Statistik Kehadiran</h2>
                    <p class="text-gray-500 mt-1">Analisis performa kehadiran guru dalam periode tertentu.</p>
                </div>
                <div>
                    <a href="{{ route('dashboard') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2.5 rounded-xl font-medium transition duration-200 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>

            {{-- FILTER --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-gray-100">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6 content-end">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}"
                            class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm py-2.5">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}"
                            class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm py-2.5">
                    </div>
                    
                    <div class="flex gap-2 items-end">
                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-xl shadow-md hover:shadow-blue-500/30 transition transform hover:-translate-y-0.5">
                            Filter
                        </button>
                        <a href="{{ route('admin.statistik.grafik', request()->all()) }}"
                           class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-bold py-2.5 rounded-xl shadow-md hover:shadow-purple-500/30 transition transform hover:-translate-y-0.5 text-center flex justify-center items-center gap-2">
                           📊 <span class="hidden xl:inline">Grafik</span>
                        </a>
                    </div>
                    
                    <div class="flex items-end">
                        <a href="{{ route('admin.statistik.cetak', request()->all()) }}"
                           class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 rounded-xl shadow-md hover:shadow-emerald-500/30 transition transform hover:-translate-y-0.5 text-center flex justify-center items-center gap-2">
                           🖨️ Cetak PDF
                        </a>
                    </div>
                </form>
                <div class="mt-4 pt-4 border-t border-gray-100 text-sm text-gray-500 flex items-center">
                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Periode: <span class="font-bold text-gray-700 ml-1">{{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}</span>
                </div>
            </div>

            {{-- TABEL STATISTIK --}}
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Guru</th>
                            <th class="px-4 py-4 text-center text-xs font-bold text-green-700 bg-green-50 uppercase tracking-wider">Hadir</th>
                            <th class="px-4 py-4 text-center text-xs font-bold text-blue-700 bg-blue-50 uppercase tracking-wider">Izin</th>
                            <th class="px-4 py-4 text-center text-xs font-bold text-yellow-700 bg-yellow-50 uppercase tracking-wider">Sakit</th>
                            <th class="px-4 py-4 text-center text-xs font-bold text-red-700 bg-red-50 uppercase tracking-wider">Bolos</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Total Telat</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Persen Hadir</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Persen Bolos</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($statistik as $s)
                            <tr class="hover:bg-blue-50/50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">{{ $s['guru'] }}</div>
                                    <div class="text-[10px] text-gray-400 font-mono">{{ $s['nip'] ?? 'NIP TIDAK ADA' }}</div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-center bg-green-50/50 font-bold text-green-700">{{ $s['hadir'] }}</td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-center bg-blue-50/50 text-blue-700">{{ $s['izin'] }}</td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-center bg-yellow-50/50 text-yellow-700">{{ $s['sakit'] }}</td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-center bg-red-50/50 font-bold text-red-700">{{ $s['bolos'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                    @if($s['menit_telat'] > 0)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-800">
                                            {{ $s['menit_telat'] }}m
                                        </span>
                                    @else
                                        <span class="text-gray-300 font-mono">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                    <div class="flex items-center justify-center">
                                        <div class="relative w-12 h-12">
                                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                                <path class="text-gray-200" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="4" />
                                                <path class="{{ $s['persentase'] >= 80 ? 'text-green-500' : ($s['persentase'] >= 50 ? 'text-yellow-500' : 'text-red-500') }}" stroke-dasharray="{{ $s['persentase'] }}, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="4" />
                                            </svg>
                                            <span class="absolute inset-0 flex items-center justify-center text-[10px] font-bold text-gray-700">{{ $s['persentase'] }}%</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                    <div class="flex items-center justify-center">
                                        <div class="relative w-12 h-12">
                                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                                <path class="text-gray-200" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="4" />
                                                <path class="text-red-500" stroke-dasharray="{{ $s['persentase_bolos'] }}, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="4" />
                                            </svg>
                                            <span class="absolute inset-0 flex items-center justify-center text-[10px] font-bold text-red-700">{{ $s['persentase_bolos'] }}%</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
