@if(session('info'))
<div class="bg-yellow-200 text-yellow-800 p-4 rounded mb-6 shadow">
    {{ session('info') }}
</div>
@endif

@if(isset($todayHoliday) && $todayHoliday)
<div class="mb-8 bg-gradient-to-r from-red-500 to-pink-600 rounded-2xl shadow-lg p-6 text-white flex items-center relative overflow-hidden">
    <div class="absolute right-0 top-0 h-full w-1/3 bg-white opacity-10 transform skew-x-12 translate-x-12"></div>
    <div class="relative z-10 flex items-center w-full">
        <div class="bg-white/20 p-3 rounded-full mr-4 backdrop-blur-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>
        <div>
            <h3 class="text-xl font-bold">Hari Ini Libur</h3>
            <p class="text-red-100 font-medium text-lg">{{ $todayHoliday->description }}</p>
            <p class="text-sm text-red-50 mt-1 opacity-90">Tidak ada jadwal absensi untuk hari ini.</p>
        </div>
    </div>
</div>
@endif

<div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
    <!-- Absen Hari Ini -->
    <a href="{{ route('absensi.create') }}"
       class="group relative overflow-hidden bg-gradient-to-br from-blue-500 to-cyan-600 text-white rounded-2xl shadow-lg p-8 transition-all duration-300 hover:shadow-2xl hover:scale-[1.02] hover:-translate-y-1">
        <div class="absolute top-0 right-0 -mt-6 -mr-6 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
        <div class="flex flex-col items-center justify-center relative z-10">
            <div class="bg-white/20 p-5 rounded-full mb-5 backdrop-blur-sm group-hover:bg-white/30 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <span class="font-bold text-xl text-center tracking-wide">Absen Hari Ini</span>
            <span class="text-sm text-blue-100 mt-2 opacity-90 group-hover:opacity-100">Klik untuk melakukan absensi</span>
        </div>
    </a>

    <!-- Riwayat Absensi -->
    <a href="{{ route('absensi.riwayat') }}"
       class="group relative overflow-hidden bg-gradient-to-br from-violet-500 to-fuchsia-600 text-white rounded-2xl shadow-lg p-8 transition-all duration-300 hover:shadow-2xl hover:scale-[1.02] hover:-translate-y-1">
        <div class="absolute top-0 right-0 -mt-6 -mr-6 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
        <div class="flex flex-col items-center justify-center relative z-10">
            <div class="bg-white/20 p-5 rounded-full mb-5 backdrop-blur-sm group-hover:bg-white/30 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
            </div>
            <span class="font-bold text-xl text-center tracking-wide">Riwayat Absensi Saya</span>
            <span class="text-sm text-violet-100 mt-2 opacity-90 group-hover:opacity-100">Lihat histori kehadiran Anda</span>
        </div>
    </a>
</div>
