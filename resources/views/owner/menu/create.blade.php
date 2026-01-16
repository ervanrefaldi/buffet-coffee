@extends('layouts.owner')

@section('title', 'Tambah Produk')
@section('subtitle', 'Silakan isi form di bawah ini untuk menambahkan produk baru.')

@section('content')
    <div class="max-w-3xl bg-white p-8 rounded-xl shadow-sm border border-gray-200">
        <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <!-- Nama Produk -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border">
                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Kategori -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select name="category" id="category" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border">
                    <option value="">-- Pilih Kategori --</option>
                    <option value="biji" {{ old('category') == 'biji' ? 'selected' : '' }}>Biji Kopi</option>
                    <option value="bubuk" {{ old('category') == 'bubuk' ? 'selected' : '' }}>Bubuk Kopi</option>
                </select>
                @error('category') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Harga & Berat -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
                    <input type="number" name="price" id="price" value="{{ old('price') }}" required min="0"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border">
                    @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="weight_kg" class="block text-sm font-medium text-gray-700">Total Berat (Kg)</label>
                    <input type="number" step="0.01" name="weight_kg" id="weight_kg" value="{{ old('weight_kg') }}" required min="0" placeholder="0.2, 1"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border">
                    @error('weight_kg') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Produk</label>
                <textarea name="description" id="description" rows="4" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-3 border">{{ old('description') }}</textarea>
                @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Gambar -->
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Foto Produk</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-amber-500 transition-colors">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600 justify-center">
                            <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-amber-600 hover:text-amber-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-amber-500">
                                <span>Upload a file</span>
                                <input id="image" name="image" type="file" class="sr-only" required>
                            </label>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, JPEG up to 200KB</p>
                    </div>
                </div>
                @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                <a href="{{ route('menu.index') }}" class="px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                    Batal
                </a>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
<script>
    const imageInput = document.getElementById('image');
    const feedbackMsg = document.createElement('p');
    feedbackMsg.className = "text-xs mt-1 font-medium";
    imageInput.parentElement.parentElement.appendChild(feedbackMsg);

    imageInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            const fileSizeKB = file.size / 1024;
            
            if (fileSizeKB > 200) {
                feedbackMsg.textContent = "Ukuran file terlalu besar (" + fileSizeKB.toFixed(2) + " KB). Maksimal 200KB.";
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
