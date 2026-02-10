<x-app-layout>
    <div class="py-12 px-4 sm:px-6 lg:px-8 bg-gray-50/50 min-h-screen">
        <div class="max-w-5xl mx-auto">

            {{-- Breadcrumb & Header --}}
            <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <nav class="flex mb-4 text-sm text-gray-400 font-bold" aria-label="Breadcrumb">
                        <ol class="flex items-center space-x-2 uppercase tracking-tighter">
                            <li><a href="{{ route('admin.absensi.index') }}" class="hover:text-blue-600 transition">Presensi</a></li>
                            <li><svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                            <li class="text-gray-900">Detail Laporan</li>
                        </ol>
                    </nav>
                    <h2 class="text-4xl font-black text-gray-900 tracking-tight">Detail Data Presensi</h2>
                    <p class="text-gray-500 mt-2 font-medium">Informasi lengkap kehadiran guru pada sekolah SDN Ciranjanggirang 2.</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.absensi.index') }}" 
                        class="bg-white hover:bg-gray-50 text-gray-700 px-6 py-3 rounded-2xl font-bold shadow-sm border border-gray-200 transition duration-200 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Kembali
                    </a>
                    <a href="{{ route('admin.absensi.edit', $absensi->id) }}" 
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-2xl font-bold shadow-lg hover:shadow-indigo-500/30 transition duration-200 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                        </svg>
                        Edit Data
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- Side Info: Guru & Status --}}
                <div class="lg:col-span-1 space-y-6">
                    {{-- Guru Identity --}}
                    <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden group">
                        <div class="bg-gradient-to-br from-indigo-600 to-blue-700 p-8 text-center relative overflow-hidden">
                            <div class="absolute inset-0 opacity-10">
                                <svg class="w-full h-full" fill="currentColor" viewBox="0 0 100 100"><circle cx="50" cy="50" r="40" /></svg>
                            </div>
                            <div class="relative mx-auto mb-4 w-28 h-28">
                                @if($absensi->user->foto_profile)
                                    <img src="{{ asset('storage/' . $absensi->user->foto_profile) }}" alt="{{ $absensi->user->name }}" 
                                        class="w-full h-full rounded-full border-4 border-white/30 object-cover shadow-2xl">
                                @else
                                    <div class="w-full h-full rounded-full border-4 border-white/30 bg-white/20 flex items-center justify-center shadow-2xl backdrop-blur-md">
                                        <span class="text-4xl font-black text-white capitalize">{{ substr($absensi->user->name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <div class="absolute -bottom-2 -right-2 h-10 w-10 bg-white rounded-full flex items-center justify-center shadow-lg">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-black text-white mb-1 leading-tight break-words px-4">{{ $absensi->user->name }}</h3>
                            <p class="text-indigo-100 font-mono text-xs tracking-[0.3em] font-bold uppercase opacity-80">{{ $absensi->user->nip ?? 'NIP TIDAK ADA' }}</p>
                        </div>
                        <div class="p-8 space-y-4">
                            <div class="flex items-center gap-4 text-gray-600">
                                <div class="h-10 w-10 bg-gray-50 rounded-xl flex items-center justify-center text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Email Address</p>
                                    <p class="text-sm font-bold text-gray-800 truncate">{{ $absensi->user->email }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 text-gray-600">
                                <div class="h-10 w-10 bg-gray-50 rounded-xl flex items-center justify-center text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Jabatan / Peran</p>
                                    <p class="text-sm font-bold text-gray-800 capitalize">{{ $absensi->user->role }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Status Card --}}
                    <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 p-10 text-center relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-gray-50 rounded-full -mr-12 -mt-12"></div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.4em] mb-6">Status Hari Ini</p>
                        
                        <div class="flex flex-col items-center">
                            @php
                                $effectiveStatus = $absensi->status;
                                if (in_array($absensi->status, ['hadir', 'telat'])) {
                                    if (!$absensi->jam_datang || !$absensi->jam_pulang) {
                                        $effectiveStatus = 'tidak_hadir';
                                    } else {
                                        $effectiveStatus = 'hadir';
                                    }
                                }
                            @endphp

                            @switch($effectiveStatus)
                                @case('hadir')
                                    <div class="p-5 bg-emerald-100 text-emerald-600 rounded-[2rem] shadow-lg shadow-emerald-200/50 mb-4 transform group-hover:scale-110 transition duration-500">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span class="text-2xl font-black text-emerald-600">HADIR</span>
                                    <span class="text-[11px] font-bold text-emerald-400 uppercase mt-1">Lengkap</span>
                                    @break
                                @case('izin')
                                    <div class="p-5 bg-blue-100 text-blue-600 rounded-[2rem] shadow-lg shadow-blue-200/50 mb-4 transform group-hover:scale-110 transition duration-500">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <span class="text-2xl font-black text-blue-600 uppercase">IZIN</span>
                                    @break
                                @case('sakit')
                                    <div class="p-5 bg-red-100 text-red-600 rounded-[2rem] shadow-lg shadow-red-200/50 mb-4 transform group-hover:scale-110 transition duration-500">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    </div>
                                    <span class="text-2xl font-black text-red-600 uppercase">SAKIT</span>
                                    @break
                                @case('tidak_hadir')
                                    <div class="p-5 bg-red-50 text-red-600 rounded-[2rem] shadow-lg shadow-red-100/50 mb-4 transform group-hover:scale-110 transition duration-500">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </div>
                                    <span class="text-2xl font-black text-red-700 uppercase">BOLOS</span>
                                    @break
                            @endswitch
                        </div>
                    </div>
                </div>

                {{-- Main Content: Details --}}
                <div class="lg:col-span-2 space-y-8">
                    
                    {{-- Time Records Section --}}
                    <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 p-8 md:p-12 relative overflow-hidden">
                        <div class="flex items-center justify-between mb-10 pb-6 border-b border-gray-100">
                            <div>
                                <h4 class="text-xl font-black text-gray-900 leading-tight">Detail Kehadiran</h4>
                                <p class="text-sm font-medium text-gray-500">Pencatatan waktu dan validitas sistem.</p>
                            </div>
                            <div class="hidden md:block">
                                @if($absensi->is_valid)
                                    <div class="flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-600 rounded-full border border-emerald-100 font-black text-[10px] uppercase tracking-widest">
                                        <span class="flex h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                        Sistem Valid
                                    </div>
                                @else
                                    <div class="flex items-center gap-2 px-4 py-2 bg-amber-50 text-amber-600 rounded-full border border-amber-100 font-black text-[10px] uppercase tracking-widest italic">
                                        Menunggu Validasi
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            {{-- Day/Date --}}
                            <div class="space-y-4">
                                <p class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em]">Hari & Tanggal</p>
                                <div class="flex items-center gap-6">
                                    <div class="h-16 w-16 bg-indigo-50 rounded-2xl flex flex-col items-center justify-center text-indigo-600 border border-indigo-100/50">
                                        <span class="text-xs font-black uppercase tracking-tighter">{{ \Carbon\Carbon::parse($absensi->tanggal)->translatedFormat('D') }}</span>
                                        <span class="text-2xl font-black leading-none">{{ \Carbon\Carbon::parse($absensi->tanggal)->format('d') }}</span>
                                    </div>
                                    <div>
                                        <p class="text-xl font-black text-gray-900">{{ \Carbon\Carbon::parse($absensi->tanggal)->translatedFormat('l') }}</p>
                                        <p class="text-sm font-bold text-gray-500">{{ \Carbon\Carbon::parse($absensi->tanggal)->translatedFormat('d F Y') }}</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Time In --}}
                            <div class="bg-gray-50/50 rounded-3xl p-6 border border-gray-100 relative overflow-hidden">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2">Jam Datang</p>
                                <div class="flex items-baseline gap-2">
                                    <span class="text-3xl font-black text-gray-900 font-mono tracking-tighter">{{ $absensi->jam_datang ? \Carbon\Carbon::parse($absensi->jam_datang)->format('H:i') : '--:--' }}</span>
                                    <span class="text-xs font-bold text-gray-400 font-mono">{{ $absensi->jam_datang ? \Carbon\Carbon::parse($absensi->jam_datang)->format(':s') : '' }}</span>
                                    <span class="ml-auto text-[10px] font-extrabold text-emerald-500 uppercase bg-white px-2 py-0.5 rounded border border-emerald-100">Masuk</span>
                                </div>
                                @if($absensi->menit_telat > 0 && $absensi->jam_datang && $absensi->jam_pulang)
                                    <div class="mt-2 text-[10px] font-black text-gray-900 bg-gray-200/50 px-3 py-1 rounded-lg inline-block">
                                        DISIPLIN: TELAT {{ $absensi->menit_telat }} MENIT
                                    </div>
                                @endif
                            </div>

                            {{-- Verifikasi (Mobile Only Block) --}}
                            <div class="md:hidden bg-gray-50/50 rounded-3xl p-6 border border-gray-100">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2">Validitas Sistem</p>
                                @if($absensi->is_valid)
                                    <p class="text-lg font-black text-emerald-600">TERVERIFIKASI ✓</p>
                                @else
                                    <p class="text-lg font-black text-amber-600">PENDING...</p>
                                @endif
                            </div>

                            {{-- Time Out --}}
                            <div class="bg-gray-50/50 rounded-3xl p-6 border border-gray-100">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2">Jam Pulang</p>
                                <div class="flex items-baseline gap-2">
                                    <span class="text-3xl font-black text-gray-900 font-mono tracking-tighter">{{ $absensi->jam_pulang ? \Carbon\Carbon::parse($absensi->jam_pulang)->format('H:i') : '--:--' }}</span>
                                    <span class="text-xs font-bold text-gray-400 font-mono">{{ $absensi->jam_pulang ? \Carbon\Carbon::parse($absensi->jam_pulang)->format(':s') : '' }}</span>
                                    <span class="ml-auto text-[10px] font-extrabold text-indigo-500 uppercase bg-white px-2 py-0.5 rounded border border-indigo-100">Pulang</span>
                                </div>
                            </div>
                        </div>

                        {{-- Reason Box --}}
                        <div class="mt-12">
                            <h5 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                                Keterangan Tambahan
                            </h5>
                            <div class="bg-gray-50 p-8 rounded-[2rem] border-2 border-dashed border-gray-200 text-gray-700 font-bold italic leading-relaxed shadow-inner">
                                "{{ $absensi->keterangan ?? 'Tidak ada pesan atau keterangan tambahan dari guru untuk laporan hari ini.' }}"
                            </div>
                        </div>

                        {{-- Location Info --}}
                        @if($absensi->latitude && $absensi->longitude)
                        <div class="mt-10 flex items-center justify-center">
                            <div class="inline-flex items-center gap-4 bg-gray-900 text-white px-6 py-3 rounded-2xl shadow-xl transform hover:scale-105 transition duration-300 cursor-default">
                                <div class="p-2 bg-blue-500 rounded-lg">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                </div>
                                <div class="text-left">
                                    <p class="text-[9px] font-black text-blue-400 uppercase tracking-tighter">Lokasi Presensi</p>
                                    <p class="text-xs font-bold font-mono">{{ $absensi->latitude }}, {{ $absensi->longitude }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    {{-- Attachment Section --}}
                    @if($absensi->lampiran)
                    <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 p-8 md:p-12">
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <h4 class="text-xl font-black text-gray-900 leading-tight">Bukti Lampiran</h4>
                                <p class="text-sm font-medium text-gray-500">Dokumen foto yang diunggah oleh guru.</p>
                            </div>
                            <a href="{{ asset('storage/' . $absensi->lampiran) }}" target="_blank" 
                                class="h-12 w-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center hover:bg-blue-600 hover:text-white transition duration-300 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                            </a>
                        </div>
                        <div class="rounded-[2.5rem] overflow-hidden border-4 border-gray-50 shadow-inner group relative">
                            <img src="{{ asset('storage/' . $absensi->lampiran) }}" alt="Bukti Absensi" class="w-full h-auto max-h-[600px] object-contain bg-gray-50">
                            <div class="absolute inset-0 bg-indigo-900/0 group-hover:bg-indigo-900/10 transition duration-500"></div>
                        </div>
                    </div>
                    @elseif(in_array($absensi->status, ['izin', 'sakit']))
                    <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 p-12 text-center">
                        <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <h4 class="text-xl font-black text-gray-900 mb-2">Lampiran Kosong</h4>
                        <p class="text-gray-500 font-medium">Guru tidak melampirkan bukti foto saat melakukan pengajuan {{ $absensi->status }}.</p>
                    </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
