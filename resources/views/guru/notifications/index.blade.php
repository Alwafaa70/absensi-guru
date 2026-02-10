<x-app-layout>
    <div class="py-12 px-6">
        <div class="max-w-4xl mx-auto">
            
            {{-- Header --}}
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800">📬 Informasi & Notifikasi</h2>
                        <p class="text-gray-500 mt-2">Lihat semua informasi dan notifikasi dari sistem</p>
                    </div>
                    @if($unreadCount > 0)
                        <form action="{{ route('guru.notifications.readAll') }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                                ✓ Tandai Semua Dibaca
                            </button>
                        </form>
                    @endif
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

            {{-- Unread Count Badge --}}
            @if($unreadCount > 0)
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r mb-6">
                    <p class="text-blue-700 font-medium">
                        🔔 Anda memiliki <span class="font-bold">{{ $unreadCount }}</span> notifikasi belum dibaca
                    </p>
                </div>
            @endif

            {{-- Notifications List --}}
            <div class="space-y-4">
                @forelse($notifications as $notification)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden border {{ $notification->is_read ? 'border-gray-200' : 'border-blue-400 ring-2 ring-blue-100' }} transition hover:shadow-lg">
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    {{-- Icon & Title --}}
                                    <div class="flex items-center gap-3 mb-2">
                                        @php
                                            $icon = '📬';
                                            $badgeColor = 'bg-gray-100 text-gray-800';
                                            
                                            if (str_contains($notification->type, 'pending')) {
                                                $icon = '⏳';
                                                $badgeColor = 'bg-yellow-100 text-yellow-800';
                                            } elseif (str_contains($notification->type, 'approved')) {
                                                $icon = '✅';
                                                $badgeColor = 'bg-green-100 text-green-800';
                                            } elseif (str_contains($notification->type, 'rejected')) {
                                                $icon = '❌';
                                                $badgeColor = 'bg-red-100 text-red-800';
                                            } elseif ($notification->type === 'broadcast') {
                                                $icon = '📢';
                                                $badgeColor = 'bg-purple-100 text-purple-800';
                                            } elseif ($notification->type === 'holiday') {
                                                $icon = '🏖️';
                                                $badgeColor = 'bg-blue-100 text-blue-800';
                                            }
                                        @endphp
                                        
                                        <span class="text-3xl">{{ $icon }}</span>
                                        <div class="flex-1">
                                            <h3 class="text-lg font-bold text-gray-900">{{ $notification->title }}</h3>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $badgeColor }}">
                                                {{ ucfirst(str_replace('_', ' ', $notification->type)) }}
                                            </span>
                                        </div>
                                        
                                        @if(!$notification->is_read)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-blue-600 text-white">
                                                BARU
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Message --}}
                                    <p class="text-gray-700 mt-3 leading-relaxed">{{ $notification->message }}</p>

                                    {{-- Image if exists --}}
                                    @if($notification->image)
                                        <div class="mt-4">
                                            <img src="{{ asset('storage/' . $notification->image) }}" 
                                                 alt="Lampiran" 
                                                 class="rounded-lg max-w-md border border-gray-200 shadow-sm">
                                        </div>
                                    @endif

                                    {{-- Timestamp --}}
                                    <p class="text-sm text-gray-500 mt-4">
                                        🕐 {{ $notification->created_at->translatedFormat('d F Y, H:i') }}
                                        <span class="text-gray-400">•</span>
                                        {{ $notification->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="flex items-center gap-2 mt-4 pt-4 border-t border-gray-100">
                                @if(!$notification->is_read)
                                    <form action="{{ route('guru.notifications.read', $notification->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Tandai Dibaca
                                        </button>
                                    </form>
                                @endif
                                
                                <form action="{{ route('guru.notifications.destroy', $notification->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus notifikasi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-xl shadow-md p-12 text-center">
                        <div class="text-6xl mb-4">📭</div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Tidak Ada Notifikasi</h3>
                        <p class="text-gray-500">Anda belum memiliki notifikasi atau informasi</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($notifications->hasPages())
                <div class="mt-8">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
