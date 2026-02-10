<x-app-layout>
    <div class="py-12 px-6">
        <div class="max-w-4xl mx-auto">
            
            {{-- Header --}}
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800">Kelola Hari Libur</h2>
                    <p class="text-gray-500 mt-1">Atur tanggal libur untuk mengecualikan absensi.</p>
                </div>
                <div>
                    <a href="{{ route('dashboard') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2.5 rounded-xl font-medium transition duration-200 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>

            {{-- Validation Errors --}}
            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-r shadow-sm mb-6 flex items-center justify-between animate-fade-in-down">
                    <div class="flex items-center">
                        <svg class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r shadow-sm mb-6">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- FORM TAMBAH HARI LIBUR --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Tambah Hari Libur Baru</h3>
                <form action="{{ route('admin.holidays.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                    @csrf
                    <div class="md:col-span-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal</label>
                        <input type="date" name="date" required
                               class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm py-2.5">
                    </div>

                    <div class="md:col-span-5">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Keterangan (Opsional)</label>
                        <input type="text" name="description" placeholder="Contoh: Cuti Bersama"
                               class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm py-2.5">
                    </div>

                    <div class="md:col-span-3">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-xl shadow-md hover:shadow-blue-500/30 transition transform hover:-translate-y-0.5">
                            + Tambah Libur
                        </button>
                    </div>
                </form>
            </div>

            {{-- TABEL HARI LIBUR --}}
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Keterangan</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse ($holidays as $holiday)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ \Carbon\Carbon::parse($holiday->date)->translatedFormat('d F Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $holiday->description ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <form action="{{ route('admin.holidays.destroy', $holiday->id) }}" method="POST"
                                          onsubmit="return confirm('Yakin hapus hari libur ini?');"
                                          class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition duration-200 text-sm font-medium flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="h-10 w-10 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p>Belum ada data hari libur</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
