<x-app-layout>
    <div class="py-12 px-6">
        <div class="max-w-7xl mx-auto">
            
            {{-- Header --}}
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800">Data Absensi Harian</h2>
                    <p class="text-gray-500 mt-1">Pantau dan kelola data absensi guru.</p>
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
                <form method="GET" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal</label>
                        <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                            class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm py-2.5">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Guru</label>
                        <input type="text" name="nama" value="{{ request('nama') }}"
                            placeholder="Cari nama..."
                            class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm py-2.5">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                        <select name="status" onchange="this.form.submit()"
                            class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm py-2.5">
                            <option value="">Semua Status</option>
                            <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>✅ Hadir</option>
                            <option value="izin" {{ request('status') == 'izin' ? 'selected' : '' }}>📝 Izin</option>
                            <option value="sakit" {{ request('status') == 'sakit' ? 'selected' : '' }}>🏥 Sakit</option>
                            <option value="bolos" {{ request('status') == 'bolos' ? 'selected' : '' }}>❌ Bolos</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Urutkan</label>
                        <select name="sort" onchange="this.form.submit()"
                            class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm py-2.5">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-xl transition shadow-md hover:shadow-blue-500/30">
                            Cari
                        </button>
                    </div>

                    <div class="flex items-end">
                        <a href="{{ route('admin.absensi.index') }}"
                            class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 rounded-xl transition text-center border border-gray-200">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            {{-- Notifications --}}
            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-r shadow-sm mb-6 flex items-center justify-between animate-fade-in-down">
                    <div class="flex items-center">
                        <svg class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            {{-- TABEL --}}
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Guru</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal & Hari</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Jam Masuk</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Jam Pulang</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Telat</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse ($absensis as $absen)
                            @php
                                $tanggalStr = \Carbon\Carbon::parse($absen->tanggal)->toDateString();
                                $isHoliday = isset($holidays[$tanggalStr]);
                                $holidayDesc = $isHoliday ? $holidays[$tanggalStr] : null;
                            @endphp
                            
                            <tr class="hover:bg-blue-50/50 transition duration-150 group {{ $isHoliday ? 'bg-yellow-50/40' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm mr-3">
                                            {{ substr($absen->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $absen->user->name }}</div>
                                            <div class="text-[10px] text-gray-400 font-mono">{{ $absen->user->nip ?? 'NIP TIDAK ADA' }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <div class="font-medium text-gray-900">
                                        {{ \Carbon\Carbon::parse($absen->tanggal)->format('d/m/Y') }}
                                        @if($isHoliday)
                                            <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-yellow-100 text-yellow-800">
                                                🏖️ Libur
                                            </span>
                                        @endif
                                    </div>
                                    <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($absen->tanggal)->translatedFormat('l') }}</div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-mono text-gray-700">
                                    @if($isHoliday)
                                        <span class="text-yellow-600 font-semibold">Libur</span>
                                    @else
                                        {{ $absen->jam_datang ?? '-' }}
                                        {{-- Info telat hanya muncul jika ada keterlambatan --}}
                                        @if($absen->menit_telat > 0 && $absen->jam_datang)
                                            <div class="text-[10px] text-gray-900 font-bold leading-none mt-1">Telat {{ $absen->menit_telat }}m</div>
                                        @endif
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-mono text-gray-700">
                                    @if($isHoliday)
                                        <span class="text-yellow-600 font-semibold">Libur</span>
                                    @else
                                        {{ $absen->jam_pulang ?? '-' }}
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($isHoliday)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            🏖️ Hari Libur
                                        </span>
                                        <div class="text-[10px] text-yellow-700 mt-1">{{ $holidayDesc }}</div>
                                    @else
                                        @php
                                            $displayStatus = $absen->status;
                                            $bgColor = 'bg-gray-100';
                                            $textColor = 'text-gray-800';
                                            $icon = '';

                                            // Status berdasarkan database
                                            if ($absen->status == 'hadir') {
                                                $displayStatus = 'Hadir';
                                                $bgColor = 'bg-green-100';
                                                $textColor = 'text-green-800';
                                                $icon = '✅';
                                            } elseif ($absen->status == 'izin') {
                                                $displayStatus = $absen->pending ? 'Menunggu Persetujuan (Izin)' : 'Izin';
                                                $bgColor = $absen->pending ? 'bg-amber-100' : 'bg-blue-100';
                                                $textColor = $absen->pending ? 'text-amber-800' : 'text-blue-800';
                                                $icon = '📝';
                                            } elseif ($absen->status == 'sakit') {
                                                $displayStatus = $absen->pending ? 'Menunggu Persetujuan (Sakit)' : 'Sakit';
                                                $bgColor = $absen->pending ? 'bg-amber-100' : 'bg-purple-100';
                                                $textColor = $absen->pending ? 'text-amber-800' : 'text-purple-800';
                                                $icon = '🏥';
                                            } elseif ($absen->status == 'bolos') {
                                                $displayStatus = 'Bolos';
                                                $bgColor = 'bg-red-100';
                                                $textColor = 'text-red-800';
                                                $icon = '❌';
                                            }
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $bgColor }} {{ $textColor }}">
                                            {{ $icon }} {{ $displayStatus }}
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                    @if($isHoliday)
                                        <span class="text-gray-400">-</span>
                                    @elseif($absen->menit_telat > 0 && $absen->jam_datang)
                                        <span class="text-red-600 font-bold">{{ $absen->menit_telat }}m</span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    @if($isHoliday)
                                        <span class="text-gray-400 text-xs italic">Tidak dapat diedit</span>
                                    @else
                                        <div class="flex items-center justify-center gap-2">
                                            @if($absen->pending && in_array($absen->status, ['izin', 'sakit']))
                                                <form action="{{ route('admin.absensi.approve', $absen->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-emerald-600 hover:text-emerald-900 bg-emerald-50 hover:bg-emerald-100 p-1.5 rounded-lg transition duration-200" title="Setujui">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.absensi.reject', $absen->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menolak pengajuan ini dan mengubahnya menjadi Bolos?')">
                                                    @csrf
                                                    <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-1.5 rounded-lg transition duration-200" title="Tolak">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('admin.absensi.show', $absen->id) }}"
                                                class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-3 py-1 rounded-lg transition duration-200" title="Selengkapnya">
                                                Detail
                                            </a>
                                            <a href="{{ route('admin.absensi.edit', $absen->id) }}"
                                                class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1 rounded-lg transition duration-200">
                                                Edit
                                            </a>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="h-10 w-10 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                        </svg>
                                        <p>Tidak ada data absensi ditemukan</p>
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
