<form action="{{ $action }}" method="POST" class="mb-6">
    @csrf
    <div class="flex gap-2">
        <input type="date" name="date" 
               class="border p-2 rounded {{ $slot }}" required>
        <input type="text" name="description" placeholder="Keterangan (opsional)" 
               class="border p-2 rounded flex-1 {{ $slot }}">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded {{ $slot }}">
            {{ $buttonText }}
        </button>
    </div>
</form>
