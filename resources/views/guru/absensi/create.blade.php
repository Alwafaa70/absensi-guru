<x-app-layout>
    
    <div class="py-12 px-6">
        <div class="max-w-md mx-auto">
            
            {{-- Header & Clock --}}
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800">Form Absensi</h2>
                <p class="text-gray-500 mt-1">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
                <div class="mt-4 bg-gray-900 text-white inline-block px-6 py-2 rounded-full font-mono text-xl shadow-lg" id="realtime-clock">
                    00:00:00
                </div>
            </div>

            {{-- Notifications --}}
            @if(session('success'))
                <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-r shadow-sm mb-6 flex items-center animate-fade-in-down">
                    <svg class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-r shadow-sm mb-6 flex items-center animate-fade-in-down">
                    <svg class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            {{-- Main Attendance Actions --}}
            <div class="bg-white shadow-xl rounded-2xl p-6 mb-8 border border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-100 rounded-full blur-3xl -mr-16 -mt-16 opacity-50"></div>
                
                <h3 class="text-lg font-bold text-gray-800 mb-2 relative z-10 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Presensi Harian
                </h3>
                
                <div class="mb-4 relative z-10 space-y-1">
                    <div class="flex items-center text-xs text-emerald-600 font-bold">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path></svg>
                        Masuk: 05:30 - 07:30 (Telat > 07:00)
                    </div>
                    <div class="flex items-center text-xs text-blue-600 font-bold">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path></svg>
                        Pulang: 12:00 - 16:00
                    </div>
                    <div class="flex items-center text-xs text-yellow-600 font-bold">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path></svg>
                        Izin/Sakit: 05:30 - 16:00
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 relative z-10">
                    {{-- ABSEN DATANG --}}
                    <form method="POST" action="{{ route('absensi.datang') }}" id="formDatang" class="w-full">
                        @csrf
                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">
                        <button type="button" onclick="submitDatang()" class="w-full flex flex-col items-center justify-center bg-gradient-to-br from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 text-white rounded-xl p-4 shadow-lg transition transform hover:-translate-y-1 group">
                            <div class="bg-white/20 p-3 rounded-full mb-2 group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                            </div>
                            <span class="font-bold">Masuk</span>
                        </button>
                    </form>

                    {{-- ABSEN PULANG --}}
                    <form method="POST" action="{{ route('absensi.pulang') }}" id="formPulang" class="w-full">
                        @csrf
                        <input type="hidden" name="latitude" id="latitude_pulang">
                        <input type="hidden" name="longitude" id="longitude_pulang">
                        <button type="button" onclick="submitPulang()" class="w-full flex flex-col items-center justify-center bg-gradient-to-br from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white rounded-xl p-4 shadow-lg transition transform hover:-translate-y-1 group">
                             <div class="bg-white/20 p-3 rounded-full mb-2 group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                            </div>
                            <span class="font-bold">Pulang</span>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Leave/Sick Form --}}
            <div class="bg-white shadow-xl rounded-2xl p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Form Izin / Sakit
                </h3>

                <form method="POST" action="{{ route('absensi.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Status Kehadiran</label>
                        <select name="status" onchange="toggleKeterangan(this.value)" class="w-full border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 transition shadow-sm">
                            <option value="">-- Pilih Status --</option>
                            <option value="izin">Izin (Perlu Persetujuan)</option>
                            <option value="sakit">Sakit (Lampirkan Keterangan)</option>
                        </select>
                    </div>

                    <div id="keterangan-box" class="hidden mb-4 space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Keterangan / Alasan</label>
                            <textarea name="keterangan" rows="3" maxlength="200" class="w-full border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 transition shadow-sm" placeholder="Jelaskan alasan izin atau sakit Anda..."></textarea>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Lampiran Foto <span class="text-xs text-gray-400 font-normal">(Opsional)</span></label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-blue-400 transition-colors group cursor-pointer relative">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-10 w-10 text-gray-400 group-hover:text-blue-500 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="lampiran" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                            <span>Upload file</span>
                                            <input id="lampiran" name="lampiran" type="file" class="sr-only" accept="image/*" onchange="updateFileName(this)">
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG up to 2MB</p>
                                </div>
                            </div>
                            <div id="file-chosen" class="mt-2 text-xs text-blue-600 font-medium italic"></div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-yellow-400 hover:bg-yellow-500 text-yellow-900 font-bold py-3 rounded-xl shadow-md transition transform hover:-translate-y-0.5">
                        Ajukan Izin / Sakit
                    </button>
                </form>
            </div>

        </div>
    </div>

    {{-- SCRIPT --}}
    <script>
        function updateFileName(input) {
            const fileName = input.files[0].name;
            document.getElementById('file-chosen').textContent = 'File terpilih: ' + fileName;
        }

        function toggleKeterangan(value) {
            const box = document.getElementById('keterangan-box');
            if (value === 'izin' || value === 'sakit') {
                box.classList.remove('hidden');
                box.classList.add('animate-fade-in');
            } else {
                box.classList.add('hidden');
            }
        }

        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            document.getElementById('realtime-clock').innerText = timeString;
        }
        setInterval(updateClock, 1000);
        updateClock();

        function submitDatang() {
            if(!navigator.geolocation) {
                alert('Geolocation tidak didukung oleh browser ini.');
                return;
            }
            navigator.geolocation.getCurrentPosition(
                function (position) {
                    document.getElementById('latitude').value = position.coords.latitude;
                    document.getElementById('longitude').value = position.coords.longitude;
                    document.getElementById('formDatang').submit();
                },
                function (error) {
                    alert('Gagal mengambil lokasi. Pastikan GPS aktif.\nError: ' + error.message);
                }
            );
        }
        function submitPulang() {
            if(!navigator.geolocation) {
                alert('Geolocation tidak didukung oleh browser ini.');
                return;
            }
            navigator.geolocation.getCurrentPosition(
                function (position) {
                    document.getElementById('latitude_pulang').value = position.coords.latitude;
                    document.getElementById('longitude_pulang').value = position.coords.longitude;
                    document.getElementById('formPulang').submit();
                },
                function (error) {
                    alert('Gagal mengambil lokasi. Pastikan GPS aktif.\nError: ' + error.message);
                }
            );
        }
    </script>
</x-app-layout>
