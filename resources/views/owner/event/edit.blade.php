@extends('layouts.owner')

@section('title', 'Edit Event')
@section('subtitle', 'Perbarui informasi detail event.')

@section('content')
    <div class="max-w-3xl bg-white p-8 rounded-xl shadow-sm border border-gray-200">
        <form action="/owner/event/{{ $event->events_id }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Judul -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Judul Event</label>
                <input type="text" name="title" id="title" value="{{ old('title', $event->title) }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border">
                @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Event</label>
                <textarea name="description" id="description" rows="4" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-3 border">{{ old('description', $event->description) }}</textarea>
                @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Tanggal -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $event->start_date) }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border">
                    @error('start_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $event->end_date) }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border">
                    @error('end_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Instagram Link -->
            <div>
                <label for="instagram_link" class="block text-sm font-medium text-gray-700">Link Instagram (Opsional)</label>
                <input type="url" name="instagram_link" id="instagram_link" value="{{ old('instagram_link', $event->instagram_link) }}" placeholder="https://www.instagram.com/p/..."
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border">
                @error('instagram_link') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Gambar -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Saat Ini</label>
                @if($event->image)
                    <img src="{{ $event->image_url }}" alt="Current Image" class="h-32 w-auto object-cover rounded-lg border border-gray-200 mb-4" referrerpolicy="no-referrer">
                @endif

                <label for="image" class="block text-sm font-medium text-gray-700">Ganti Gambar (Opsional)</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-amber-500 transition-colors">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600 justify-center">
                            <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-amber-600 hover:text-amber-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-amber-500">
                                <span>Upload a file</span>
                                <input id="image" name="image" type="file" class="sr-only">
                            </label>
                        </div>
                        <p class="text-xs text-gray-500">Biarkan kosong jika tidak ingin mengubah</p>
                    </div>
                </div>
                @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                <a href="/owner/event" class="px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                    Batal
                </a>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
<script>
    const imageInput = document.getElementById('image');
    // Cari elemen pembungkus input file untuk menaruh pesan error
    const inputContainer = imageInput.closest('.border-dashed').parentElement; 
    
    const feedbackMsg = document.createElement('p');
    feedbackMsg.className = "text-xs mt-1 font-medium";
    inputContainer.appendChild(feedbackMsg);

    imageInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            const fileSizeKB = file.size / 1024;
            
            if (fileSizeKB > 1024) {
                feedbackMsg.textContent = "Ukuran file terlalu besar (" + fileSizeKB.toFixed(2) + " KB). Maksimal 1MB.";
                feedbackMsg.classList.remove('text-green-600');
                feedbackMsg.classList.add('text-red-600');
                this.value = ''; // Reset input
            } else {
                feedbackMsg.textContent = "Ukuran file sesuai (" + fileSizeKB.toFixed(2) + " KB).";
                feedbackMsg.classList.remove('text-red-600');
                feedbackMsg.classList.add('text-green-600');
            }
        }
    });
</script>
@endsection
