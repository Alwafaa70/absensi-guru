<x-app-layout>
    <div class="py-12 px-6">
        <div class="max-w-3xl mx-auto">
            
            {{-- Header --}}
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800">✏️ Edit Broadcast</h2>
                        <p class="text-gray-500 mt-2">Perbarui pesan broadcast yang sudah dikirim</p>
                    </div>
                    <a href="{{ route('admin.broadcast.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition">
                        Kembali ke Riwayat
                    </a>
                </div>
            </div>

            {{-- Success/Error Message --}}
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

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r shadow-sm mb-6">
                    <div class="flex items-center">
                        <svg class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <p>{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            {{-- Form --}}
            <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-100">
                <form action="{{ route('admin.broadcast.update', $broadcast->broadcast_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Title --}}
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-bold text-gray-700 mb-2">
                            Judul Informasi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="title" 
                               id="title" 
                               value="{{ old('title', $broadcast->title) }}"
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
                                  required>{{ old('message', $broadcast->message) }}</textarea>
                        @error('message')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Current Image --}}
                    @if($broadcast->image)
                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                Foto Saat Ini
                            </label>
                            <div class="relative inline-block">
                                <img src="{{ asset('storage/' . $broadcast->image) }}" 
                                     alt="Current Image" 
                                     class="rounded-lg max-w-md border border-gray-200 shadow-sm">
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Upload foto baru untuk mengganti foto ini</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Image Upload --}}
                    <div class="mb-6">
                        <label for="image" class="block text-sm font-bold text-gray-700 mb-2">
                            {{ $broadcast->image ? 'Ganti Foto (Opsional)' : 'Lampiran Foto (Opsional)' }}
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-blue-400 transition">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                        <span>Upload foto baru</span>
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
                            <p class="text-sm font-medium text-gray-700 mb-2">Preview Foto Baru:</p>
                            <img id="preview" src="" alt="Preview" class="rounded-lg max-w-md border border-gray-200 shadow-sm">
                        </div>
                    </div>

                    {{-- Warning Box --}}
                    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-r mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    <strong>Perhatian:</strong> Perubahan ini akan memperbarui pesan untuk <strong>SEMUA GURU</strong> yang menerima broadcast ini. 
                                    Pastikan perubahan yang Anda buat sudah benar.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="flex items-center justify-between">
                        <a href="{{ route('admin.broadcast.index') }}" class="text-gray-600 hover:text-gray-800 font-medium">
                            ← Batal
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl transition shadow-lg hover:shadow-blue-500/30">
                            💾 Simpan Perubahan
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
