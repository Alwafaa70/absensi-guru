<x-app-layout>
    <div class="py-8 px-4 sm:px-6">
        <div class="max-w-7xl mx-auto space-y-6">
            
            {{-- Compact Profile Header Card --}}
            <div class="relative bg-white/40 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/40 overflow-hidden p-6 group">
                <!-- Abstract Background Shapes -->
                <div class="absolute -top-16 -right-16 w-48 h-48 bg-indigo-500/10 rounded-full blur-3xl group-hover:bg-indigo-500/20 transition-all duration-700"></div>
                <div class="absolute -bottom-16 -left-16 w-48 h-48 bg-blue-500/10 rounded-full blur-3xl group-hover:bg-blue-500/20 transition-all duration-700"></div>

                <div class="relative z-10">
                    {{-- Welcome & Clock Section (Above Avatar) --}}
                    <div class="text-center mb-6">
                        <div class="inline-flex items-center gap-3 bg-gradient-to-r from-indigo-600 via-blue-600 to-blue-700 text-white px-6 py-3 rounded-2xl shadow-lg mb-4">
                            <div class="text-left">
                                <h3 class="text-lg font-bold">Selamat Datang 🙌</h3>
                                <p class="text-blue-100 text-xs opacity-90">Dashboard Absensi SDN Ciranjanggirang 2</p>
                            </div>
                            <div class="border-l border-white/30 pl-3 ml-3">
                                <div class="text-blue-100 text-[10px] font-medium opacity-80">Waktu Server</div>
                                <div class="text-lg font-black tabular-nums tracking-tight" id="dashboard-clock">00:00:00</div>
                            </div>
                        </div>
                    </div>

                    {{-- Avatar & User Info Section --}}
                    <div class="flex flex-col items-center">
                        {{-- Avatar --}}
                        <div class="relative mb-4">
                            <div class="absolute inset-0 bg-gradient-to-tr from-indigo-500 to-blue-500 rounded-full blur-lg opacity-40 animate-pulse"></div>
                            @if(auth()->user()->foto_profile)
                                <img src="{{ asset('storage/' . auth()->user()->foto_profile) }}" alt="{{ auth()->user()->name }}" 
                                    class="relative w-24 h-24 rounded-full border-4 border-white object-cover shadow-2xl transition transform hover:scale-105 duration-300">
                            @else
                                <div class="relative w-24 h-24 rounded-full border-4 border-white bg-gradient-to-tr from-indigo-100 to-blue-50 flex items-center justify-center shadow-2xl">
                                    <span class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-tr from-indigo-600 to-blue-600">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        {{-- User Info --}}
                        <div class="text-center">
                            <h1 class="text-2xl font-black text-gray-900 tracking-tight mb-1">
                                 {{ auth()->user()->name }}
                            </h1>
                            <p class="text-gray-500 font-mono text-xs mb-1 tracking-widest">
                                {{ auth()->user()->nip ?? (in_array(auth()->user()->status_kepegawaian, ['pns', 'pppk']) ? 'NIP BELUM DIISI' : 'NUPTK BELUM DIISI') }}
                            </p>
                            <p class="text-gray-400 text-[10px] mb-3">
                                {{ in_array(auth()->user()->status_kepegawaian, ['pns', 'pppk']) ? 'NIP' : 'NUPTK' }}
                            </p>
                            <div class="flex items-center justify-center gap-2 mb-3">
                                @if(auth()->user()->role === 'guru')
                                    @if(auth()->user()->status_kepegawaian == 'pns')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                            </svg>
                                            Guru PNS
                                        </span>
                                    @elseif(auth()->user()->status_kepegawaian == 'pppk')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                            </svg>
                                            Guru PPPK
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                            </svg>
                                            Guru Honor
                                        </span>
                                    @endif
                                @endif
                            </div>
                            <div class="inline-flex items-center px-4 py-1.5 rounded-full bg-white/60 backdrop-blur-sm shadow-sm border border-black/5">
                                <span class="flex h-2 w-2 rounded-full bg-green-500 mr-2"></span>
                                <span class="text-xs font-bold text-gray-600 uppercase tracking-widest">
                                    {{ auth()->user()->role ?? 'Guru' }} Access
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Role Specific Content --}}
            <div class="bg-white/40 backdrop-blur-xl rounded-3xl shadow-2xl p-8 border border-white/40">
                @if(auth()->user()->role === 'admin')
                    @include('dashboard.admin')
                @elseif(auth()->user()->role === 'guru')
                    @include('dashboard.guru')
                @else
                    <div class="flex flex-col items-center py-10">
                        <div class="p-4 bg-red-100 rounded-2xl mb-4">
                            <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <p class="text-red-600 font-black text-xl">Role tidak dikenali.</p>
                        <p class="text-gray-500 mt-2">Silahkan hubungi administrator sistem.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function updateDashboardClock() {
            const now = new Date();
            const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            document.getElementById('dashboard-clock').textContent = timeStr;
        }
        setInterval(updateDashboardClock, 1000);
        updateDashboardClock();
    </script>
</x-app-layout>
