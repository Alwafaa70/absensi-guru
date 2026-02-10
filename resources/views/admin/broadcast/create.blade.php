<x-app-layout>
    <div class="py-12 px-6">
        <div class="max-w-3xl mx-auto">
            
            {{-- Header --}}
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800">📢 Kirim Informasi ke Semua Guru</h2>
                        <p class="text-gray-500 mt-2">Broadcast pesan penting ke seluruh guru</p>
                    </div>
                    <a href="{{ route('admin.broadcast.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition">
                        Riwayat Broadcast
                    </a>
                </div>
            </div>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-r shadow-sm mb-6 animate-fade-in-down">
                    <div class="flex items-center">
                        <svg class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            {{-- Form --}}
            <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-100">
                <form action="{{ route('admin.broadcast.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Title --}}
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-bold text-gray-700 mb-2">
                            Judul Informasi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="title" 
                               id="title" 
                               value="{{ old('title') }}"
                               class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm @error('title') border-red-500 @enderror"
                               placeholder="Contoh: Informasi Penting - Rapat Guru"
                               required>
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Message --}}
                    <div class="mb-6">
                        <label for="message" class="block text-sm font-bold text-gray-700 mb-2">
                            Pesan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="message" 
                                  id="message" 
                                  rows="8"
                                  class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm @error('message') border-red-500 @enderror"
                                  placeholder="Tulis pesan informasi yang ingin disampaikan ke semua guru..."
                                  required>{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-sm text-gray-500 mt-2">
                            💡 Tip: Tulis pesan dengan jelas dan lengkap. Semua guru akan menerima notifikasi ini.
                        </p>
                    </div>

                    {{-- Image Upload --}}
                    <div class="mb-6">
                        <label for="image" class="block text-sm font-bold text-gray-700 mb-2">
                            Lampiran Foto (Opsional)
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-blue-400 transition">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                        <span>Upload foto</span>
                                        <input id="image" name="image" type="file" class="sr-only" accept="image/*" onchange="previewImage(event)">
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 2MB</p>
                            </div>
                        </div>
                        @error('image')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        
                        {{-- Image Preview --}}
                        <div id="imagePreview" class="mt-4 hidden">
                            <img id="preview" src="" alt="Preview" class="rounded-lg max-w-md border border-gray-200 shadow-sm">
                        </div>
                    </div>

                    {{-- Info Box --}}
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    <strong>Perhatian:</strong> Pesan ini akan dikirim ke <strong>SEMUA GURU</strong> yang terdaftar di sistem. 
                                    Pastikan informasi yang Anda kirim sudah benar dan penting.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="flex items-center justify-between">
                        <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-800 font-medium">
                            ← Kembali
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl transition shadow-lg hover:shadow-blue-500/30">
                            📢 Kirim ke Semua Guru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- JavaScript for Image Preview --}}
    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                    document.getElementById('imagePreview').classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
</x-app-layout>
