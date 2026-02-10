<x-app-layout>
    <div class="py-12 px-6">
        <div class="max-w-2xl mx-auto">
            
            {{-- Header --}}
            <div class="mb-8 text-center">
                <h2 class="text-3xl font-bold text-gray-800">Tambah Guru Baru</h2>
                <p class="text-gray-500 mt-2">Isi formulir di bawah ini untuk menambahkan akun guru baru ke sistem.</p>
            </div>

            <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-100">
                
                @if($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6">
                        <div class="flex items-center mb-2">
                            <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="font-bold">Terjadi Kesalahan:</span>
                        </div>
                        <ul class="list-disc list-inside text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.guru.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" 
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm placeholder-gray-400"
                            placeholder="Contoh: Budi Santoso, S.Pd." 
                            required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Status Kepegawaian</label>
                        <select name="status_kepegawaian" id="status_kepegawaian"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm"
                            required onchange="updateNipLabel()">
                            <option value="honor" {{ old('status_kepegawaian') == 'honor' ? 'selected' : '' }}>Guru Honor</option>
                            <option value="pns" {{ old('status_kepegawaian') == 'pns' ? 'selected' : '' }}>Guru PNS</option>
                            <option value="pppk" {{ old('status_kepegawaian') == 'pppk' ? 'selected' : '' }}>Guru PPPK</option>
                        </select>
                        <p class="text-xs text-gray-500 mt-2 flex items-center">
                            <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Pilih status kepegawaian guru
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <span id="nip-label">NUPTK</span> 
                            <span class="text-gray-400 font-normal">(Wajib)</span>
                        </label>
                        <input type="text" name="nip" id="nip" value="{{ old('nip') }}" 
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm placeholder-gray-400"
                            placeholder="Nomor Unik Pendidik dan Tenaga Kependidikan">
                        <p class="text-xs text-gray-500 mt-2" id="nip-hint">
                            NUPTK untuk guru honor
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" 
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm placeholder-gray-400"
                            placeholder="nama@email.com" 
                            required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                        <input type="password" name="password" 
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm placeholder-gray-400"
                            placeholder="••••••••" 
                            required>
                        <p class="text-xs text-gray-500 mt-2 flex items-center">
                            <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Minimal 6 karakter
                        </p>
                    </div>

                    <div class="flex items-center gap-4 pt-4">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl shadow-lg hover:shadow-blue-500/30 transition transform hover:-translate-y-0.5">
                            Simpan Data
                        </button>
                        <a href="{{ route('admin.guru.index') }}" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 rounded-xl transition text-center border border-gray-200">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function updateNipLabel() {
            const status = document.getElementById('status_kepegawaian').value;
            const label = document.getElementById('nip-label');
            const input = document.getElementById('nip');
            const hint = document.getElementById('nip-hint');
            
            if (status === 'pns' || status === 'pppk') {
                label.textContent = 'NIP';
                input.placeholder = 'Nomor Induk Pegawai';
                hint.textContent = status === 'pns' ? 'NIP untuk guru PNS' : 'NIP untuk guru PPPK';
            } else {
                label.textContent = 'NUPTK';
                input.placeholder = 'Nomor Unik Pendidik dan Tenaga Kependidikan';
                hint.textContent = 'NUPTK untuk guru honor';
            }
        }
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', updateNipLabel);
    </script>
</x-app-layout>
