<section>
    <header class="mb-10">
        <div class="flex items-center gap-3 mb-2">
            <span class="h-6 w-1.5 bg-indigo-600 rounded-full"></span>
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">
                {{ __('Update Profile') }}
            </h2>
        </div>
        <p class="text-sm text-gray-500 font-medium leading-relaxed">
            {{ __("Perbarui rincian identitas Anda, NIP, serta alamat email resmi Anda.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-8 space-y-8" enctype="multipart/form-data">
        @csrf
        @method('patch')

        {{-- Foto Profile Section --}}
        <div class="flex flex-col sm:flex-row items-center gap-8 p-8 bg-gradient-to-br from-gray-50 to-white rounded-3xl border border-gray-100 shadow-inner">
            <div class="relative shrink-0 group/photo">
                <div id="image-preview-container" class="relative">
                    @if($user->foto_profile)
                        <img id="image-preview" src="{{ asset('storage/' . $user->foto_profile) }}" alt="Profile" class="w-32 h-32 rounded-full object-cover shadow-2xl border-4 border-white transition duration-500 group-hover/photo:scale-105">
                    @else
                        <div id="image-placeholder" class="w-32 h-32 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-4xl font-black border-4 border-white shadow-xl transition duration-500 group-hover/photo:scale-105">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <img id="image-preview" src="#" alt="Preview" class="hidden w-32 h-32 rounded-full object-cover shadow-2xl border-4 border-white transition duration-500 group-hover/photo:scale-105">
                    @endif
                    
                    <label for="foto_profile" class="absolute bottom-1 right-1 bg-indigo-600 hover:bg-indigo-700 text-white p-2.5 rounded-full shadow-lg border-2 border-white cursor-pointer transition duration-300 transform hover:scale-110">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </label>
                </div>
                <input id="foto_profile" name="foto_profile" type="file" class="hidden" accept="image/*" onchange="previewImage(this)" />
            </div>
            <div class="flex-1 w-full text-center sm:text-left">
                <h3 class="text-lg font-black text-gray-900 mb-1">Pas Foto Profil</h3>
                <p class="text-sm text-gray-500 mb-4 font-medium leading-relaxed">Klik ikon kamera untuk mengunggah foto baru. Gunakan format JPG atau PNG (Maks. 2MB).</p>
                <div class="flex flex-wrap justify-center sm:justify-start gap-2">
                    <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-[10px] font-black uppercase tracking-widest border border-indigo-100 italic">Identitas Resmi</span>
                    <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-[10px] font-black uppercase tracking-widest border border-emerald-100 italic">Disarankan Formal</span>
                </div>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('foto_profile')" />
        </div>

        <script>
            function previewImage(input) {
                const preview = document.getElementById('image-preview');
                const placeholder = document.getElementById('image-placeholder');
                
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                        if (placeholder) placeholder.classList.add('hidden');
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Name --}}
            <div class="space-y-2">
                <x-input-label for="name" :value="__('Nama Lengkap')" class="font-bold text-gray-700 ml-1" />
                <x-text-input id="name" name="name" type="text" class="block w-full rounded-2xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500/20 shadow-sm px-4 py-3" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            {{-- NIP --}}
            <div class="space-y-2">
                <x-input-label for="nip" :value="__('NIP (Nomor Induk Pegawai)')" class="font-bold text-gray-700 ml-1" />
                <x-text-input id="nip" name="nip" type="text" class="block w-full rounded-2xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500/20 shadow-sm px-4 py-3" :value="old('nip', $user->nip)" required placeholder="Masukkan NIP Anda" />
                <x-input-error class="mt-2" :messages="$errors->get('nip')" />
            </div>
        </div>

        {{-- Email --}}
        <div class="space-y-2">
            <x-input-label for="email" :value="__('Alamat Email Resmi')" class="font-bold text-gray-700 ml-1" />
            <x-text-input id="email" name="email" type="email" class="block w-full rounded-2xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500/20 shadow-sm px-4 py-3" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-4 p-4 bg-amber-50 rounded-2xl border border-amber-100 flex items-center gap-3">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <div class="flex-1">
                        <p class="text-xs font-bold text-amber-800">{{ __('Alamat email Anda belum terverifikasi.') }}</p>
                        <button form="send-verification" class="text-[11px] font-black text-indigo-600 hover:underline">
                            {{ __('Klik untuk kirim ulang email verifikasi.') }}
                        </button>
                    </div>
                </div>
            @endif
        </div>

        {{-- Save Button --}}
        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3.5 rounded-2xl font-black shadow-lg shadow-indigo-600/20 hover:shadow-indigo-600/30 transition transform hover:-translate-y-1">
                {{ __('Simpan Perubahan') }}
            </button>
            
            <a href="{{ route('dashboard') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-8 py-3.5 rounded-2xl font-black transition border border-gray-200">
                {{ __('Batal') }}
            </a>

            @if (session('status') === 'profile-updated')
                <div 
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="flex items-center gap-2 text-emerald-600 ml-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span class="text-sm font-black uppercase tracking-widest">{{ __('Tersimpan') }}</span>
                </div>
            @endif
        </div>
    </form>
</section>
