@extends('layouts.owner')

@section('title', 'Kelola Menu')
@section('subtitle', 'Daftar semua produk yang tersedia.')

@section('content')
    <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Daftar Produk</h2>
            <a href="{{ route('menu.create') }}" class="bg-amber-600 text-white px-4 py-2 rounded-lg hover:bg-amber-700 transition shadow-sm text-sm font-medium">
                + Tambah Produk
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Mobile View (Cards) -->
        <div class="grid grid-cols-1 gap-4 md:hidden">
            @forelse($products as $product)
            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 flex flex-col space-y-3">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0 h-16 w-16 bg-gray-100 rounded-lg overflow-hidden">
                        <img class="h-full w-full object-cover" style="width:100%; height:100%; object-fit:cover;" src="{{ $product->image_url }}" alt="{{ $product->name }}">
                    </div>
                <div class="flex-1">
                        <div class="text-base font-bold text-gray-900">{{ $product->name }}</div>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->category == 'biji' ? 'bg-amber-100 text-amber-800' : 'bg-brown-100 text-brown-800' }} mt-1">
                            {{ $product->category == 'biji' ? 'Biji Kopi' : 'Bubuk Kopi' }} ({{ ucfirst($product->coffee_variant) }})
                        </span>
                        <div class="text-xs text-gray-500 mt-1 space-y-0.5">
                            <div>Stok 200g: <span class="font-bold">{{ $product->stock_200g }}</span></div>
                            <div>Stok 500g: <span class="font-bold">{{ $product->stock_500g }}</span></div>
                            <div>Stok 1Kg: <span class="font-bold">{{ $product->stock_1kg }}</span></div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 p-3 rounded-md text-sm space-y-1">
                    <div class="flex justify-between"><span>200g:</span> <span class="font-medium">Rp {{ number_format($product->price_200g, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>500g:</span> <span class="font-medium">Rp {{ number_format($product->price_500g, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>1kg:</span> <span class="font-medium">Rp {{ number_format($product->price_1kg, 0, ',', '.') }}</span></div>
                </div>
 
                <div class="flex justify-end space-x-3 pt-2 border-t border-gray-100">
                    <a href="{{ route('menu.edit', $product->products_id) }}" class="flex-1 text-center bg-amber-50 text-amber-700 py-2 rounded-lg font-medium hover:bg-amber-100">Edit</a>
                    <form action="{{ route('menu.destroy', $product->products_id) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-50 text-red-700 py-2 rounded-lg font-medium hover:bg-red-100">Hapus</button>
                    </form>
                </div>
            </div>
            @empty
            <div class="bg-white p-8 text-center text-gray-500 rounded-lg border border-gray-200">
                Belum ada produk.
            </div>
            @endforelse
        </div>
 
        <!-- Desktop View (Table) -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok (Kg)</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga (200g | 500g | 1kg)</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($products as $product)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-gray-100 rounded-full overflow-hidden">
                                    <img class="h-full w-full object-cover" style="width:100%; height:100%; object-fit:cover;" src="{{ $product->image_url }}" alt="{{ $product->name }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->category == 'biji' ? 'bg-amber-100 text-amber-800' : 'bg-brown-100 text-brown-800' }}">
                                {{ $product->category == 'biji' ? 'Biji' : 'Bubuk' }} - {{ ucfirst($product->coffee_variant) }}
                            </span>
                        </td>
                         <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="text-xs space-y-1">
                                <div>200g: <span class="font-bold text-gray-700">{{ $product->stock_200g }}</span></div>
                                <div>500g: <span class="font-bold text-gray-700">{{ $product->stock_500g }}</span></div>
                                <div>1Kg : <span class="font-bold text-gray-700">{{ $product->stock_1kg }}</span></div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex flex-col space-y-1 text-xs">
                                <span>200g: Rp {{ number_format($product->price_200g, 0, ',', '.') }}</span>
                                <span>500g: Rp {{ number_format($product->price_500g, 0, ',', '.') }}</span>
                                <span>1kg: Rp {{ number_format($product->price_1kg, 0, ',', '.') }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('menu.edit', $product->products_id) }}" class="text-amber-600 hover:text-amber-900 mr-3">Edit</a>
                            <form action="{{ route('menu.destroy', $product->products_id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                            Belum ada produk.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
@endsection
