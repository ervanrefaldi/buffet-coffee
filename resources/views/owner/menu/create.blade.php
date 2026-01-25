@extends('layouts.owner')

@section('title', 'Tambah Produk')
@section('subtitle', 'Silakan isi form di bawah ini untuk menambahkan produk baru.')

@section('content')
    <div class="max-w-3xl bg-white p-8 rounded-xl shadow-sm border border-gray-200">
        @if ($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Ada kesalahan!</strong>
                <ul class="mt-1 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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

            <!-- Stok -->
            <div>
                <label for="stock" class="block text-sm font-medium text-gray-700">Stok (Kg)</label>
                <input type="number" step="0.01" name="stock" id="stock" value="{{ old('stock') }}" required min="0" placeholder="Contoh: 10.5"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border">
                @error('stock') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Varian Harga (200gr, 500gr, 1kg) -->
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <h3 class="text-sm font-medium text-gray-700 mb-4 border-b pb-2">Varian Harga</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- 200 Gram -->
                    <div>
                        <label for="price_200g" class="block text-xs font-medium text-gray-500 mb-1">Harga 200 Gram</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">Rp</span>
                            </div>
                            <input type="number" name="price_200g" id="price_200g" value="{{ old('price_200g') }}" required min="0"
                                class="pl-12 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border">
                        </div>
                        @error('price_200g') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- 500 Gram -->
                    <div>
                        <label for="price_500g" class="block text-xs font-medium text-gray-500 mb-1">Harga 500 Gram</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">Rp</span>
                            </div>
                            <input type="number" name="price_500g" id="price_500g" value="{{ old('price_500g') }}" required min="0"
                                class="pl-12 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border">
                        </div>
                        @error('price_500g') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- 1 Kg -->
                    <div>
                        <label for="price_1kg" class="block text-xs font-medium text-gray-500 mb-1">Harga 1 Kg</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">Rp</span>
                            </div>
                            <input type="number" name="price_1kg" id="price_1kg" value="{{ old('price_1kg') }}" required min="0"
                                class="pl-12 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border">
                        </div>
                        @error('price_1kg') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
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
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Foto Produk</label>
                
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-amber-500 transition-colors relative">
                    
                    <!-- Container Preview (Konten akan diganti JS) -->
                    <div class="space-y-1 text-center" id="upload-preview">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600 justify-center">
                            <span class="relative cursor-pointer bg-white rounded-md font-medium text-amber-600 hover:text-amber-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-amber-500">
                                <span>Upload a file</span>
                            </span>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, JPEG up to 1MB</p>
                    </div>

                    <!-- Input Actual (Hidden but exists!) -->
                    <input id="image" name="image" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" required accept="image/png, image/jpeg, image/jpg" onchange="previewImage(this)">
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
    function previewImage(input) {
        const previewContainer = document.getElementById('upload-preview');
        const file = input.files[0];

        if (file) {
            // Validate size (1MB) - Strict Client Side
            if (file.size > 1024 * 1024) {
                alert("Maaf, ukuran file terlalu besar! Maksimal 1MB.");
                input.value = ""; // Reset input
                resetPreview();   // Reset UI
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                // Update UI Preview
                previewContainer.innerHTML = `
                    <div class="flex flex-col items-center">
                        <img src="${e.target.result}" class="h-40 w-auto mb-3 rounded-lg shadow-md object-contain border border-gray-200">
                        <p class="text-xs font-bold text-green-600">Foto Siap Upload</p>
                        <p class="text-[10px] text-gray-400">${file.name}</p>
                        <p class="text-[10px] text-amber-600 font-bold mt-1">Klik area ini lagi untuk ganti foto</p>
                    </div>
                `;
            }
            reader.readAsDataURL(file);
        }
    }

    function resetPreview() {
        const previewContainer = document.getElementById('upload-preview');
        previewContainer.innerHTML = `
            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <div class="flex text-sm text-gray-600 justify-center">
                <span class="relative cursor-pointer bg-white rounded-md font-medium text-amber-600 hover:text-amber-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-amber-500">
                    <span>Upload a file</span>
                </span>
            </div>
            <p class="text-xs text-gray-500">PNG, JPG, JPEG up to 1MB</p>
        `;
    }
</script>
@endsection
