<x-app-layout>
    <div class="py-12 px-6">
        <div class="max-w-7xl mx-auto">
            
            {{-- Header --}}
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-gray-800">Riwayat Absensi</h2>
                <p class="text-gray-500 mt-1">Lihat dan filter catatan kehadiran Anda.</p>
            </div>

            {{-- FILTER --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-gray-100">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Tanggal</label>
                        <input type="date" name="tanggal"
                            value="{{ request('tanggal') }}"
                            class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm py-2.5">
                    </div>
        
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Urutkan Data</label>
                        <select name="sort"
                            class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm py-2.5">
                            <option value="desc" {{ request('sort', 'desc')=='desc' ? 'selected' : '' }}>
                                Terbaru (Default)
                            </option>
                            <option value="asc" {{ request('sort')=='asc' ? 'selected' : '' }}>
                                Terlama
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                        <select name="status"
                            class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm py-2.5">
                            <option value="">Semua Status</option>
                            <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                            <option value="izin" {{ request('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                            <option value="sakit" {{ request('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                            <option value="bolos" {{ request('status') == 'bolos' ? 'selected' : '' }}>Bolos</option>
                        </select>
                    </div>
        
                    <div class="flex items-end">
                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-xl transition shadow-md hover:shadow-blue-500/30">
                            Terapkan Filter
                        </button>
                    </div>
        
                    <div class="flex items-end">
                        <a href="{{ route('absensi.riwayat') }}"
                            class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 rounded-xl transition text-center border border-gray-200">
                            Reset Filter
                        </a>
                    </div>
                </form>

                {{-- ACTIVE FILTERS INDICATOR --}}
                @if(request('tanggal') || request('sort') || request('status'))
                    <div class="mt-6 flex flex-wrap gap-2 pt-4 border-t border-gray-100">
                        <span class="text-sm font-medium text-gray-500 self-center mr-2">Status Filter:</span>
                        @if(request('tanggal'))
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                📅 {{ \Carbon\Carbon::parse(request('tanggal'))->translatedFormat('d F Y') }}
                            </span>
                        @endif
                        @if(request('sort'))
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800">
                                🔄 Urutan: {{ request('sort') == 'desc' ? 'Terbaru' : 'Terlama' }}
                            </span>
                        @endif
                        @if(request('status'))
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                📊 Status: {{ str_replace('_', ' ', ucfirst(request('status'))) }}
                            </span>
                        @endif
                    </div>
                @endif
            </div>

            {{-- DATA SUMMARY --}}
            <div class="flex justify-between items-center mb-4">
                <p class="text-gray-600 font-medium">
                    @if(request('tanggal') || request('sort') || request('status'))
                        Ditemukan <span class="text-blue-600 font-bold">{{ $absensis->total() }}</span> data
                    @else
                        Total <span class="text-blue-600 font-bold">{{ $absensis->total() }}</span> riwayat absensi
                    @endif
                </p>
            </div>
    
            {{-- TABLE --}}
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Hari</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Jam Masuk</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Jam Pulang</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Telat</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($absensis as $absen)
                            @php
                                $tanggalStr = \Carbon\Carbon::parse($absen->tanggal)->toDateString();
                                $isHoliday = isset($holidays[$tanggalStr]);
                                $holidayDesc = $isHoliday ? $holidays[$tanggalStr] : null;
                            @endphp
                            
                            <tr class="hover:bg-blue-50/50 transition duration-150 {{ $isHoliday ? 'bg-yellow-50/30' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ \Carbon\Carbon::parse($absen->tanggal)->translatedFormat('d F Y') }}
                                    @if($isHoliday)
                                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-yellow-100 text-yellow-800">
                                            🏖️ Libur
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($absen->tanggal)->translatedFormat('l') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-mono text-gray-700">
                                    @if($isHoliday)
                                        <span class="text-yellow-600 font-semibold">Libur</span>
                                    @elseif($absen->jam_datang)
                                        <span class="{{ $absen->menit_telat > 0 ? 'text-red-600 font-bold' : '' }}">
                                            {{ \Carbon\Carbon::parse($absen->jam_datang)->format('H:i') }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-mono text-gray-700">
                                    @if($isHoliday)
                                        <span class="text-yellow-600 font-semibold">Libur</span>
                                    @else
                                        {{ $absen->jam_pulang ? \Carbon\Carbon::parse($absen->jam_pulang)->format('H:i') : '-' }}
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($isHoliday)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            🏖️ Hari Libur
                                        </span>
                                    @else
                                        @php
                                            $displayStatus = $absen->status;
                                            $bgColor = 'bg-gray-100';
                                            $textColor = 'text-gray-800';

                                            if ($absen->status == 'hadir') {
                                                if (!$absen->jam_datang || !$absen->jam_pulang) {
                                                    $displayStatus = 'bolos';
                                                    $bgColor = 'bg-red-100';
                                                    $textColor = 'text-red-800';
                                                } else {
                                                    $displayStatus = 'hadir';
                                                    $bgColor = 'bg-green-100';
                                                    $textColor = 'text-green-800';
                                                }
                                            } 
                                            elseif ($absen->status == 'izin') {
                                                $bgColor = $absen->pending ? 'bg-amber-100' : 'bg-blue-100';
                                                $textColor = $absen->pending ? 'text-amber-800' : 'text-blue-800';
                                                $displayStatus = $absen->pending ? 'Menunggu Persetujuan' : 'izin';
                                            } elseif ($absen->status == 'sakit') {
                                                $bgColor = $absen->pending ? 'bg-amber-100' : 'bg-red-50';
                                                $textColor = $absen->pending ? 'text-amber-800' : 'text-red-700';
                                                $displayStatus = $absen->pending ? 'Menunggu Persetujuan' : 'sakit';
                                            } elseif ($absen->status == 'bolos') {
                                                $bgColor = 'bg-red-100';
                                                $textColor = 'text-red-800';
                                                $displayStatus = 'Bolos';
                                            }
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $bgColor }} {{ $textColor }}">
                                            {{ str_replace('_', ' ', ucfirst($displayStatus)) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                    @if($isHoliday)
                                        <span class="text-gray-400">-</span>
                                    @elseif($absen->menit_telat > 0)
                                        <span class="text-red-600 font-bold">{{ $absen->menit_telat }}m</span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 text-center max-w-xs truncate">
                                    @if($isHoliday)
                                        <span class="text-yellow-700 font-medium">{{ $holidayDesc }}</span>
                                    @else
                                        {{ $absen->keterangan ?? '-' }}
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="bg-gray-100 p-4 rounded-full mb-4">
                                            <svg class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900">Tidak ada riwayat absensi</h3>
                                        <p class="mt-1 text-gray-500 text-sm">Data kehadiran Anda belum tersedia atau tidak cocok dengan filter.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $absensis->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
