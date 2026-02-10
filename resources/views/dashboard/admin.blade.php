<div class="mb-6 text-center">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">SDN CIRANJANGGIRANG 2</h1>
    <p class="text-gray-500 text-sm md:text-base">Mencetak Generasi Cerdas dan Berkarakter</p>
</div>

<h4 class="mb-6 text-center text-xl font-semibold mb-6 text-gray-700">Menu Admin</h4>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
    <!-- Kelola Akun Guru -->
    <a href="{{ route('admin.guru.index') }}"
       class="group relative overflow-hidden bg-gradient-to-br from-emerald-500 to-teal-600 text-white rounded-2xl shadow-lg p-6 transition-all duration-300 hover:shadow-2xl hover:scale-[1.03] hover:-translate-y-1">
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full blur-xl group-hover:scale-150 transition-transform duration-500"></div>
        <div class="flex flex-col items-center justify-center relative z-10">
            <div class="bg-white/20 p-4 rounded-full mb-4 backdrop-blur-sm group-hover:bg-white/30 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <span class="font-bold text-lg text-center tracking-wide">Kelola Akun Guru</span>
            <span class="text-xs text-emerald-100 mt-2 opacity-0 group-hover:opacity-100 transition-opacity transform translate-y-2 group-hover:translate-y-0">Manajemen Data Pengajar</span>
        </div>
    </a>

    <!-- Kelola Absensi Guru -->
    <a href="{{ route('admin.absensi.index') }}"
       class="group relative overflow-hidden bg-gradient-to-br from-rose-500 to-pink-600 text-white rounded-2xl shadow-lg p-6 transition-all duration-300 hover:shadow-2xl hover:scale-[1.03] hover:-translate-y-1">
        @if(isset($pendingApprovals) && $pendingApprovals > 0)
            <div class="absolute top-4 right-4 z-20">
                <span class="relative flex h-6 w-6">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-6 w-6 bg-white text-rose-600 text-[10px] font-black items-center justify-center shadow-lg border border-rose-100">
                        {{ $pendingApprovals }}
                    </span>
                </span>
            </div>
        @endif
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full blur-xl group-hover:scale-150 transition-transform duration-500"></div>
        <div class="flex flex-col items-center justify-center relative z-10">
            <div class="bg-white/20 p-4 rounded-full mb-4 backdrop-blur-sm group-hover:bg-white/30 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
            </div>
            <span class="font-bold text-lg text-center tracking-wide">Kelola Absensi</span>
            <span class="text-xs text-rose-100 mt-2 opacity-0 group-hover:opacity-100 transition-opacity transform translate-y-2 group-hover:translate-y-0">Edit & Verifikasi Absen</span>
        </div>
    </a>

    <!-- Statistik Absensi Guru -->
    <a href="{{ route('admin.statistik.index') }}"
       class="group relative overflow-hidden bg-gradient-to-br from-amber-400 to-orange-500 text-white rounded-2xl shadow-lg p-6 transition-all duration-300 hover:shadow-2xl hover:scale-[1.03] hover:-translate-y-1">
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full blur-xl group-hover:scale-150 transition-transform duration-500"></div>
        <div class="flex flex-col items-center justify-center relative z-10">
            <div class="bg-white/20 p-4 rounded-full mb-4 backdrop-blur-sm group-hover:bg-white/30 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <span class="font-bold text-lg text-center tracking-wide">Statistik & Laporan</span>
            <span class="text-xs text-amber-100 mt-2 opacity-0 group-hover:opacity-100 transition-opacity transform translate-y-2 group-hover:translate-y-0">Grafik & Cetak PDF</span>
        </div>
    </a>

    <!-- Kelola Hari Libur -->
    <a href="{{ route('admin.holidays.index') }}"
       class="group relative overflow-hidden bg-gradient-to-br from-indigo-500 to-purple-600 text-white rounded-2xl shadow-lg p-6 transition-all duration-300 hover:shadow-2xl hover:scale-[1.03] hover:-translate-y-1">
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full blur-xl group-hover:scale-150 transition-transform duration-500"></div>
        <div class="flex flex-col items-center justify-center relative z-10">
            <div class="bg-white/20 p-4 rounded-full mb-4 backdrop-blur-sm group-hover:bg-white/30 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M3 11h18M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <span class="font-bold text-lg text-center tracking-wide">Kelola Hari Libur</span>
            <span class="text-xs text-indigo-100 mt-2 opacity-0 group-hover:opacity-100 transition-opacity transform translate-y-2 group-hover:translate-y-0">Pengaturan Kalender</span>
        </div>
    </a>
</div>

