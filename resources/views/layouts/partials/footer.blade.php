<footer class="mt-20 pb-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white/40 backdrop-blur-xl border border-white/40 rounded-[2.5rem] p-10 shadow-2xl overflow-hidden relative group">
            <!-- Shapes -->
            <div class="absolute -top-24 -left-24 w-64 h-64 bg-blue-500/5 rounded-full blur-3xl group-hover:bg-blue-500/10 transition-all duration-700"></div>
            <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-indigo-500/5 rounded-full blur-3xl group-hover:bg-indigo-500/10 transition-all duration-700"></div>

            <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
                <div class="flex flex-col items-center md:items-start text-center md:text-left">
                    <div class="flex items-center space-x-4 mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto">
                        <h3 class="text-2xl font-black tracking-tighter text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">
                            Guru Cirgir 2
                        </h3>
                    </div>
                    <p class="text-gray-500 font-medium max-w-xs leading-relaxed">
                        Mencetak Generasi Cerdas dan Berkarakter melalui sistem digital terintegrasi.
                    </p>
                </div>

                <div class="flex flex-wrap justify-center gap-6">
                    <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-blue-600 font-bold text-sm transition transition-all duration-300 hover:scale-110">Dashboard</a>
                    <a href="{{ route('profile.edit') }}" class="text-gray-600 hover:text-blue-600 font-bold text-sm transition transition-all duration-300 hover:scale-110">Profil</a>
                    <a href="#" class="text-gray-600 hover:text-blue-600 font-bold text-sm transition transition-all duration-300 hover:scale-110">Bantuan</a>
                </div>

                <div class="text-center md:text-right">
                    <div class="bg-indigo-600 px-6 py-2 rounded-full inline-block mb-3 shadow-lg shadow-indigo-600/20">
                        <span class="text-white text-xs font-black uppercase tracking-widest">Official Platform</span>
                    </div>
                    <p class="text-xs text-gray-400 font-bold">
                        &copy; {{ date('Y') }} SDN CIRANJANGGIRANG 2
                    </p>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-black/5 text-center relative z-10">
                <p class="text-[10px] text-gray-400 font-black uppercase tracking-[0.2em]">
                    Dibuat dengan ❤️ oleh Tim IT SDN Ciranjanggirang 2
                </p>
            </div>
        </div>
    </div>
</footer>
