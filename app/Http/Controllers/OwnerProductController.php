<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Services\ImgBBService;

class OwnerProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(10);
        return view('owner.menu.index', compact('products'));
    }

    public function create()
    {
        return view('owner.menu.create');
    }

    public function store(Request $request)
    {
        // Detect POST Size Violation
        if (!$request->has('name')) {
             return back()->withErrors(['image' => 'Gagal: File terlalu besar (Melebihi batas server ' . ini_get('post_max_size') . '). Mohon kompres foto di bawah 5MB.'])->withInput();
        }

        $request->validate([
            'name'           => 'required|string|max:100',
            'category'       => 'required|in:biji,bubuk',
            'coffee_variant' => 'required|in:robusta,arabica',
            'stock_200g'     => 'required|integer|min:0',
            'stock_500g'     => 'required|integer|min:0',
            'stock_1kg'      => 'required|integer|min:0',
            'price_200g'     => 'required|numeric|min:0',
            'price_500g'     => 'required|numeric|min:0',
            'price_1kg'      => 'required|numeric|min:0',
            'description'    => 'required|string',
            'image'          => 'required|image|mimes:jpeg,png,jpg|max:5120'
        ], [
            'image.max' => 'Ukuran gambar maksimal 5MB.'
        ]);
        
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = ImgBBService::upload($request->file('image'));
            
            if (!$imagePath) {
                return back()->withErrors(['image' => 'Gagal mengunggah gambar ke ImgBB. Silakan coba lagi.'])->withInput();
            }
        }

        Product::create([
            'name'           => $request->name,
            'category'       => $request->category,
            'coffee_variant' => $request->coffee_variant,
            'stock_200g'     => $request->stock_200g,
            'stock_500g'     => $request->stock_500g,
            'stock_1kg'      => $request->stock_1kg,
            'price_200g'     => $request->price_200g,
            'price_500g'     => $request->price_500g,
            'price_1kg'      => $request->price_1kg,
            'description'    => $request->description,
            'image'          => $imagePath
        ]);

        return redirect()->route('menu.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('owner.menu.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Detect POST Size Violation
        if (!$request->has('name')) {
             return back()->withErrors(['image' => 'Gagal: File terlalu besar (Melebihi batas server ' . ini_get('post_max_size') . '). Mohon kompres foto di bawah 5MB.'])->withInput();
        }

        $request->validate([
            'name'           => 'required|string|max:100',
            'category'       => 'required|in:biji,bubuk',
            'coffee_variant' => 'required|in:robusta,arabica',
            'stock_200g'     => 'required|integer|min:0',
            'stock_500g'     => 'required|integer|min:0',
            'stock_1kg'      => 'required|integer|min:0',
            'price_200g'     => 'required|numeric|min:0',
            'price_500g'     => 'required|numeric|min:0',
            'price_1kg'      => 'required|numeric|min:0',
            'description'    => 'required|string',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg|max:5120'
        ], [
            'image.max' => 'Ukuran gambar maksimal 5MB.'
        ]);

        $data = $request->except(['image']);

        if ($request->hasFile('image')) {
            $newImagePath = ImgBBService::upload($request->file('image'));
            
            if (!$newImagePath) {
                return back()->withErrors(['image' => 'Gagal mengunggah gambar ke ImgBB. Silakan coba lagi.'])->withInput();
            }

            // Hapus gambar lama jika ada (lokal)
            if ($product->image && !str_starts_with($product->image, 'http')) {
                Storage::disk('public')->delete($product->image);
            }
            
            // Simpan gambar baru
            $data['image'] = $newImagePath;
        }

        $product->update($data);

        return redirect()->route('menu.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // Hapus gambar dari storage (lokal)
        if ($product->image && !str_starts_with($product->image, 'http')) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('menu.index')->with('success', 'Produk berhasil dihapus.');
    }
}

