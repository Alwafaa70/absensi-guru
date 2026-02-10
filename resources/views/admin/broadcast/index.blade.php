<x-app-layout>
    <div class="py-12 px-6">
        <div class="max-w-5xl mx-auto">
            
            {{-- Header --}}
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800">📋 Riwayat Broadcast</h2>
                        <p class="text-gray-500 mt-2">Lihat semua pesan yang telah dikirim ke guru</p>
                    </div>
                    <a href="{{ route('admin.broadcast.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-medium transition shadow-md">
                        ➕ Kirim Broadcast Baru
                    </a>
                </div>
            </div>

            {{-- Broadcasts List --}}
            <div class="space-y-4">
                @forelse($broadcasts as $broadcast)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 transition hover:shadow-lg">
                        <div class="p-6">
                            <div class="flex items-start gap-4">
                                <div class="text-4xl">📢</div>
                                <div class="flex-1">
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $broadcast->title }}</h3>
                                    <p class="text-gray-700 leading-relaxed mb-4">{{ $broadcast->message }}</p>

                                    {{-- Image if exists --}}
                                    @if($broadcast->image)
                                        <div class="mb-4">
                                            <img src="{{ asset('storage/' . $broadcast->image) }}" 
                                                 alt="Lampiran" 
                                                 class="rounded-lg max-w-md border border-gray-200 shadow-sm">
                                        </div>
                                    @endif

                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-4 text-sm text-gray-500">
                                            <span class="flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ \Carbon\Carbon::parse($broadcast->created_at)->translatedFormat('d F Y, H:i') }}
                                            </span>
                                            <span class="text-gray-400">•</span>
                                            <span>{{ \Carbon\Carbon::parse($broadcast->created_at)->diffForHumans() }}</span>
                                        </div>

                                        {{-- Action Buttons --}}
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('admin.broadcast.edit', $broadcast->broadcast_id) }}" 
                                               class="inline-flex items-center gap-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                Edit
                                            </a>

                                            <form action="{{ route('admin.broadcast.destroy', $broadcast->broadcast_id) }}" 
                                                  method="POST" 
                                                  class="inline"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus broadcast ini? Pesan akan dihapus dari semua guru!')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="inline-flex items-center gap-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-xl shadow-md p-12 text-center">
                        <div class="text-6xl mb-4">📭</div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Broadcast</h3>
                        <p class="text-gray-500 mb-6">Anda belum pernah mengirim broadcast ke guru</p>
                        <a href="{{ route('admin.broadcast.create') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-medium transition">
                            Kirim Broadcast Pertama
                        </a>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($broadcasts->hasPages())
                <div class="mt-8">
                    {{ $broadcasts->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
