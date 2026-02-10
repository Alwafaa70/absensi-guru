<x-app-layout>
    <div class="py-12 px-6">
        <div class="max-w-2xl mx-auto">
            
            {{-- Header --}}
            <div class="mb-8 text-center">
                <h2 class="text-3xl font-bold text-gray-800">Edit Data Absensi</h2>
                <p class="text-gray-500 mt-1">Perbarui detail kehadiran guru secara manual.</p>
            </div>

            <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-100">
                
                {{-- Info Card --}}
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r mb-8">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Informasi Absensi</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <p><span class="font-semibold">Nama Guru:</span> {{ $absensi->user->name }}</p>
                                <p><span class="font-semibold">Tanggal:</span> {{ \Carbon\Carbon::parse($absensi->tanggal)->translatedFormat('l, d F Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.absensi.update', $absensi->id) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- STATUS --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Status Kehadiran</label>
                        <select name="status" id="status"
                            class="w-full border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 transition shadow-sm py-2.5">
                            <option value="hadir" {{ $absensi->status == 'hadir' ? 'selected' : '' }}>✅ Hadir</option>
                            <option value="izin" {{ $absensi->status == 'izin' ? 'selected' : '' }}>📝 Izin</option>
                            <option value="sakit" {{ $absensi->status == 'sakit' ? 'selected' : '' }}>🏥 Sakit</option>
                            <option value="bolos" {{ $absensi->status == 'bolos' ? 'selected' : '' }}>❌ Bolos</option>
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Admin dapat mengubah status apapun, termasuk status bolos otomatis.</p>
                    </div>

                    {{-- WAKTU (Jam Datang & Pulang) --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Jam Masuk</label>
                            <input type="time" name="jam_datang" step="1"
                                value="{{ $absensi->jam_datang }}"
                                class="w-full border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 transition shadow-sm py-2.5">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Jam Pulang</label>
                            <input type="time" name="jam_pulang" step="1"
                                value="{{ $absensi->jam_pulang }}"
                                class="w-full border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 transition shadow-sm py-2.5">
                        </div>
                    </div>

                    {{-- MENIT TELAT --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Menit Telat</label>
                        <input type="number" name="menit_telat"
                            value="{{ $absensi->menit_telat }}"
                            class="w-full border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 transition shadow-sm py-2.5"
                            placeholder="0">
                        <p class="text-xs text-gray-500 mt-1">Kosongkan atau isi 0 jika tidak telat.</p>
                    </div>

                    {{-- KETERANGAN --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Keterangan / Catatan</label>
                        <textarea name="keterangan"
                            class="w-full border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 transition shadow-sm py-2.5"
                            rows="3" placeholder="Tambahkan catatan jika diperlukan...">{{ $absensi->keterangan }}</textarea>
                    </div>

                    <div class="flex items-center gap-4 pt-4">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl shadow-lg hover:shadow-blue-500/30 transition transform hover:-translate-y-0.5">
                            Simpan Data
                        </button>
                        <a href="{{ route('admin.absensi.index') }}" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 rounded-xl transition text-center border border-gray-200">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
