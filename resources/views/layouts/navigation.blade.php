<nav x-data="{ open: false }" class="bg-white/90 backdrop-blur-md border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- LEFT -->
            <div class="flex items-center space-x-8">

                <!-- LOGO -->
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-auto group-hover:scale-110 transition-transform duration-300">
                    <span class="text-xl font-black tracking-tighter text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 group-hover:from-blue-700 group-hover:to-indigo-700 transition">
                        Guru Cirgir 2
                    </span>
                </a>

                <!-- MENU -->
                <div class="hidden sm:flex space-x-1">

                    <a href="{{ route('dashboard') }}"
                       class="px-3 py-2 rounded-lg text-sm font-medium transition duration-150 ease-in-out {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        Dashboard
                    </a>

                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.guru.index') }}"
                           class="px-3 py-2 rounded-lg text-sm font-medium transition duration-150 ease-in-out {{ request()->routeIs('admin.guru.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            Kelola Guru
                        </a>

                        <a href="{{ route('admin.absensi.index') }}"
                           class="px-3 py-2 rounded-lg text-sm font-medium transition duration-150 ease-in-out {{ request()->routeIs('admin.absensi.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            Kelola Absensi
                        </a>

                        <a href="{{ route('admin.statistik.index') }}"
                           class="px-3 py-2 rounded-lg text-sm font-medium transition duration-150 ease-in-out {{ request()->routeIs('admin.statistik.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            Statistik
                        </a>
                        
                        <a href="{{ route('admin.holidays.index') }}"
                           class="px-3 py-2 rounded-lg text-sm font-medium transition duration-150 ease-in-out {{ request()->routeIs('admin.holidays.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            Hari Libur
                        </a>
                        
                        <a href="{{ route('admin.broadcast.create') }}"
                           class="px-3 py-2 rounded-lg text-sm font-medium transition duration-150 ease-in-out {{ request()->routeIs('admin.broadcast.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            📢 Broadcast
                        </a>
                    @endif

                    @if(auth()->user()->role === 'guru')
                        <a href="{{ route('absensi.create') }}"
                           class="px-3 py-2 rounded-lg text-sm font-medium transition duration-150 ease-in-out {{ request()->routeIs('absensi.create') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            Absen
                        </a>

                        <a href="{{ route('absensi.riwayat') }}"
                           class="px-3 py-2 rounded-lg text-sm font-medium transition duration-150 ease-in-out {{ request()->routeIs('absensi.riwayat') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            Riwayat
                        </a>
                        
                        <a href="{{ route('guru.notifications.index') }}"
                           class="px-3 py-2 rounded-lg text-sm font-medium transition duration-150 ease-in-out relative {{ request()->routeIs('guru.notifications.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            📬 Informasi
                            @php
                                $unreadCount = \App\Models\Notification::where('user_id', auth()->id())->where('is_read', false)->count();
                            @endphp
                            @if($unreadCount > 0)
                                <span class="absolute -top-1 -right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                                    {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                                </span>
                            @endif
                        </a>
                    @endif
                </div>
            </div>

            <!-- RIGHT -->
            <div class="flex items-center space-x-4">

                <!-- PROFILE DROPDOWN -->
                <div x-data="{ openProfile: false }" class="relative">

                    <button @click="openProfile = !openProfile"
                        class="flex items-center space-x-3 focus:outline-none group">

                        <span class="hidden sm:block text-sm font-medium text-gray-700 group-hover:text-indigo-600 transition">
                            {{ auth()->user()->name }}
                        </span>

                        <!-- FOTO PROFIL -->
                        @if(auth()->user()->foto_profile)
                            <img
                                src="{{ asset('storage/' . auth()->user()->foto_profile) }}"
                                class="w-10 h-10 rounded-full object-cover border-2 border-gray-100 group-hover:border-indigo-500 transition shadow-sm"
                            >
                        @else
                            <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold border-2 border-gray-100 group-hover:border-indigo-500 transition shadow-sm">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        @endif
                    </button>

                    <!-- DROPDOWN -->
                    <div x-show="openProfile"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         @click.outside="openProfile = false"
                         class="absolute right-0 mt-2 w-56 bg-white border border-gray-100 rounded-xl shadow-xl z-50 overflow-hidden">

                        <div class="px-5 py-3 bg-gray-50 border-b border-gray-100">
                            <p class="text-sm font-bold text-gray-800">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                        </div>

                        <div class="py-1">
                            <a href="{{ route('profile.edit') }}"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                                👤 Profil Saya
                            </a>

                            <div class="border-t border-gray-100 my-1"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition font-medium">
                                    🚪 Logout
                                </button>
                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</nav>
