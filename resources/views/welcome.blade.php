<!-- resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Absensi Guru - SDN Ciranjanggirang 2</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex">

    <!-- Left Side: Branding -->
    <div class="hidden lg:flex w-1/2 bg-gradient-to-br from-blue-600 to-indigo-800 text-white flex-col justify-center items-center relative overflow-hidden">
        <div class="absolute inset-0 bg-white/10 mix-blend-overlay"></div>
        <div class="absolute top-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-80 h-80 bg-yellow-400/20 rounded-full blur-3xl translate-x-1/3 translate-y-1/3"></div>
        
        <div class="relative z-10 text-center px-12">
            <div class="mb-8 flex justify-center">
                <div class="bg-white/10 backdrop-blur-md p-6 rounded-full border border-white/20 shadow-2xl">
                    <img src="{{ asset('images/logo.png') }}" alt="Tut Wuri Handayani" class="h-32 w-auto brightness-110 drop-shadow-xl animate-float">
                </div>
            </div>
            <h1 class="text-5xl font-black mb-4 tracking-tight">Sistem Absensi Guru Cirgir 2</h1>
            <p class="text-2xl text-blue-100 mb-10 font-medium">SDN Ciranjanggirang 2</p>
            <div class="bg-white/20 backdrop-blur-md rounded-2xl p-6 border border-white/20 shadow-xl inline-block group hover:bg-white/30 transition-all duration-300">
                <p class="text-sm font-bold tracking-widest uppercase">"Mencetak Generasi Cerdas dan Berkarakter"</p>
            </div>
        </div>
    </div>

    <!-- Right Side: Login Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white">
        <div class="w-full max-w-md">
            <div class="text-center mb-10 lg:hidden flex flex-col items-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 w-auto mb-4">
                <h2 class="text-3xl font-black text-gray-800 tracking-tighter">Guru Cirgir 2</h2>
                <p class="text-gray-500 font-medium italic">SDN Ciranjanggirang 2</p>
            </div>
            
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Selamat Datang</h2>
                <p class="text-gray-500">Silakan login untuk mengakses akun Anda.</p>
            </div>

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 flex items-start gap-3 animate-shake">
                    <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 flex items-start gap-3 animate-shake">
                    <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="email">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-3 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm placeholder-gray-400"
                        placeholder="nama@sekolah.id">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="password">Password</label>
                    <input id="password" type="password" name="password" required
                        class="w-full px-4 py-3 border @error('password') border-red-500 @else border-gray-300 @enderror rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm placeholder-gray-400"
                        placeholder="••••••••">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">Lupa Password?</a>
                    @endif
                </div>

                <button type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl shadow-lg transition transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600">
                    Masuk
                </button>
            </form>

            <p class="text-center text-gray-400 text-sm mt-8">
                &copy; {{ date('Y') }} Sistem Absensi SDN Ciranjanggirang 2
            </p>
        </div>
    </div>

</body>
</html>
