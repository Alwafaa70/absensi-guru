<section>
    <header class="mb-10">
        <div class="flex items-center gap-3 mb-2">
            <span class="h-6 w-1.5 bg-blue-600 rounded-full"></span>
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">
                {{ __('Update Password') }}
            </h2>
        </div>
        <p class="text-sm text-gray-500 font-medium leading-relaxed">
            {{ __('Gunakan kata sandi yang kuat untuk menjaga keamanan akun Anda setiap saat.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-8 space-y-8">
        @csrf
        @method('put')

        <div class="space-y-6">
            {{-- Current Password --}}
            <div class="space-y-2">
                <x-input-label for="update_password_current_password" :value="__('Kata Sandi Saat Ini')" class="font-bold text-gray-700 ml-1" />
                <x-text-input id="update_password_current_password" name="current_password" type="password" class="block w-full rounded-2xl border-gray-200 focus:border-blue-500 focus:ring-blue-500/20 shadow-sm" autocomplete="current-password" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- New Password --}}
                <div class="space-y-2">
                    <x-input-label for="update_password_password" :value="__('Kata Sandi Baru')" class="font-bold text-gray-700 ml-1" />
                    <x-text-input id="update_password_password" name="password" type="password" class="block w-full rounded-2xl border-gray-200 focus:border-blue-500 focus:ring-blue-500/20 shadow-sm" autocomplete="new-password" />
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                </div>

                {{-- Confirm Password --}}
                <div class="space-y-2">
                    <x-input-label for="update_password_password_confirmation" :value="__('Konfirmasi Kata Sandi')" class="font-bold text-gray-700 ml-1" />
                    <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="block w-full rounded-2xl border-gray-200 focus:border-blue-500 focus:ring-blue-500/20 shadow-sm" autocomplete="new-password" />
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                </div>
            </div>
        </div>

        {{-- Save Button --}}
        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3.5 rounded-2xl font-black shadow-lg shadow-blue-600/20 hover:shadow-blue-600/30 transition transform hover:-translate-y-1">
                {{ __('Perbarui Password') }}
            </button>

            <a href="{{ route('dashboard') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-8 py-3.5 rounded-2xl font-black transition border border-gray-200">
                {{ __('Batal') }}
            </a>

            @if (session('status') === 'password-updated')
                <div 
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="flex items-center gap-2 text-emerald-600 ml-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span class="text-sm font-black uppercase tracking-widest">{{ __('Password Diperbarui') }}</span>
                </div>
            @endif
        </div>
    </form>
</section>
