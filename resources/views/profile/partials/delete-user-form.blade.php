<section class="space-y-8 p-6">
    <header>
        <div class="flex items-center gap-3 mb-2">
            <span class="h-6 w-1.5 bg-red-600 rounded-full"></span>
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">
                {{ __('Hapus Akun') }}
            </h2>
        </div>

        <p class="text-sm text-gray-500 font-medium leading-relaxed">
            {{ __('Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Pastikan Anda telah mengunduh data penting sebelum melanjutkan.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="rounded-2xl px-8 py-3 font-black shadow-lg shadow-red-600/20 hover:shadow-red-600/30 transition transform hover:-translate-y-1"
    >{{ __('Hapus Akun Permanen') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-10">
            @csrf
            @method('delete')

            <h2 class="text-2xl font-black text-gray-900 mb-4">
                {{ __('Apakah Anda yakin ingin menghapus akun?') }}
            </h2>

            <p class="text-sm text-gray-500 font-medium leading-relaxed mb-8">
                {{ __('Tindakan ini tidak dapat dibatalkan. Silakan masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun secara permanen.') }}
            </p>

            <div class="space-y-2">
                <x-input-label for="password" value="{{ __('Password Konfirmasi') }}" class="font-bold text-gray-700" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="block w-full rounded-2xl border-gray-200 focus:border-red-500 focus:ring-red-500/20 shadow-sm"
                    placeholder="{{ __('Masukkan Password Anda') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-10 flex justify-end gap-4">
                <button type="button" x-on:click="$dispatch('close')" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-2xl font-bold transition">
                    {{ __('Batal') }}
                </button>

                <x-danger-button class="rounded-2xl px-8 py-3 font-black shadow-lg shadow-red-600/20 hover:shadow-red-600/30 transition">
                    {{ __('Ya, Hapus Akun') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
