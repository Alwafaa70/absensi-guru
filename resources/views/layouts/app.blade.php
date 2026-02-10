<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

       

    </head>
    <body class="font-sans antialiased bg-slate-50 min-h-screen relative overflow-x-hidden selection:bg-indigo-500 selection:text-white"
      style="background-image: url('{{ asset('images/wpgaris.jpg') }}'); background-size: cover; background-attachment: fixed; background-position: center;">
      
      <!-- Premium Overlay Layer -->
      <div class="fixed inset-0 bg-white/40 backdrop-blur-[2px] pointer-events-none"></div>
      <div class="fixed inset-0 bg-gradient-to-br from-indigo-500/5 via-transparent to-blue-500/5 pointer-events-none"></div>

      <div class="relative min-h-screen">


            @include('layouts.navigation')

            {{-- Flash Messages --}}
            @if(session('success'))
                <div x-data="{ show: true }" 
                     x-show="show" 
                     x-init="setTimeout(() => show = false, 5000)"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-y-[-20px]"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 transform translate-y-0"
                     x-transition:leave-end="opacity-0 transform translate-y-[-20px]"
                     class="fixed top-20 right-4 z-[9999] max-w-sm w-full bg-white/80 backdrop-blur-md border border-emerald-500/20 shadow-2xl rounded-2xl p-4 flex items-center space-x-3">
                    <div class="flex-shrink-0 w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-gray-900">Success!</p>
                        <p class="text-xs text-gray-600">{{ session('success') }}</p>
                    </div>
                    <button @click="show = false" class="text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
         {{-- Footer --}}
    @include('layouts.partials.footer')
    </body>
</html>
