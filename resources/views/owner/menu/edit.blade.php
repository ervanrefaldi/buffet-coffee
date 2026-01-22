@extends('layouts.owner')

@section('title', 'Edit Produk')
@section('subtitle', 'Edit data produk.')

@section('content')
    <div class="max-w-3xl bg-white p-8 rounded-xl shadow-sm border border-gray-200">
        <form action="{{ route('menu.update', $product->products_id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Nama Produk -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border">
                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Kategori -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select name="category" id="category" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border">
                    <option value="biji" {{ old('category', $product->category) == 'biji' ? 'selected' : '' }}>Biji Kopi</option>
                    <option value="bubuk" {{ old('category', $product->category) == 'bubuk' ? 'selected' : '' }}>Bubuk Kopi</option>
                </select>
                @error('category') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Stok -->
            <div>
                <label for="stock" class="block text-sm font-medium text-gray-700">Stok (Kg)</label>
                <input type="number" step="0.01" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" required min="0"
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
                            <input type="number" name="price_200g" id="price_200g" value="{{ old('price_200g', $product->price_200g) }}" required min="0"
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
                            <input type="number" name="price_500g" id="price_500g" value="{{ old('price_500g', $product->price_500g) }}" required min="0"
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
                            <input type="number" name="price_1kg" id="price_1kg" value="{{ old('price_1kg', $product->price_1kg) }}" required min="0"
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
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-3 border">{{ old('description', $product->description) }}</textarea>
                @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Gambar -->
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Foto Produk</label>
                
                @if($product->image)
                    <div class="mb-2">
                        <p class="text-xs text-gray-500 mb-1">Foto Saat Ini:</p>
                        <img src="{{ asset($product->image) }}" class="h-24 w-24 object-cover rounded-md border">
                    </div>
                @endif
                
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-amber-500 transition-colors">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600 justify-center">
                            <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-amber-600 hover:text-amber-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-amber-500">
                                <span>Ganti Foto (Opsional)</span>
                                <input id="image" name="image" type="file" class="sr-only">
                            </label>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, JPEG up to 1MB</p>
                    </div>
                </div>
                @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                <a href="{{ route('menu.index') }}" class="px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                    Batal
                </a>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                    Update Produk
                </button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/@imgly/background-removal@1.4.5/dist/index.js"></script>
<script>
    const imageInput = document.getElementById('image');
    const form = document.querySelector('form');
    const submitBtn = form.querySelector('button[type="submit"]');
    
    // Create UI Feedback Elements
    const dropzone = imageInput.closest('.border-dashed');
    const dropzoneContent = dropzone.querySelector('div');
    
    // Loading Template
    const loadingUI = `
        <div id="ai-loading" class="flex flex-col items-center justify-center space-y-4 py-4">
            <div class="relative w-16 h-16">
                <div class="absolute inset-0 border-4 border-amber-100 rounded-full"></div>
                <div class="absolute inset-0 border-4 border-amber-600 rounded-full border-t-transparent animate-spin"></div>
            </div>
            <div class="space-y-1">
                <p class="text-sm font-bold text-amber-900 uppercase tracking-widest">AI Sedang Bekerja</p>
                <p class="text-[10px] text-amber-600/70 font-medium">Menghapus background foto...</p>
            </div>
        </div>
    `;

    imageInput.addEventListener('change', async function() {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            
            // Validate size before AI processing
            if (file.size > 5 * 1024 * 1024) { // 5MB limit
                alert("Ukuran file terlalu besar untuk diproses AI (Maks 5MB).");
                this.value = '';
                return;
            }

            // Show Loading UI
            const originalContent = dropzoneContent.innerHTML;
            dropzoneContent.innerHTML = loadingUI;
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');

            try {
                // RUN AI BACKGROUND REMOVAL
                const blob = await imglyRemoveBackground(file, {
                    publicPath: 'https://cdn.jsdelivr.net/npm/@imgly/background-removal@1.4.5/dist/',
                    progress: (item, progress) => {
                        console.log(`AI Processing ${item}: ${Math.round(progress * 100)}%`);
                    }
                });

                // Create a new File object from the blob
                const newFile = new File([blob], file.name.replace(/\.[^/.]+$/, "") + "_transparent.png", {
                    type: "image/png"
                });

                // Update Input with processed file
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(newFile);
                this.files = dataTransfer.files;

                // Success Preview UI
                dropzoneContent.innerHTML = `
                    <div class="flex flex-col items-center">
                        <img src="${URL.createObjectURL(blob)}" class="h-32 w-auto mb-2 drop-shadow-lg rounded-lg border-2 border-amber-500/20">
                        <p class="text-xs font-bold text-green-600">✨ Background Berhasil Dihapus!</p>
                        <p class="text-[10px] text-gray-400 mt-1">Foto lama akan diganti dengan versi transparan premium.</p>
                        <button type="button" onclick="window.location.reload()" class="mt-2 text-red-500 hover:underline text-[10px] font-bold uppercase">Ganti Foto</button>
                    </div>
                `;

            } catch (error) {
                console.error("AI Background Removal Error:", error);
                alert("Gagal memproses gambar. Silakan coba lagi.");
                dropzoneContent.innerHTML = originalContent;
            } finally {
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }
    });
</script>
@endsection
