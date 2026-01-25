<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
        Log::info('Menu Store Attempt', $request->all());
        
        $request->validate([
            'name'        => 'required|string|max:100',
            'category'    => 'required|in:biji,bubuk',
            'stock'       => 'required|numeric|min:0',
            'price_200g'  => 'required|numeric|min:0',
            'price_500g'  => 'required|numeric|min:0',
            'price_1kg'   => 'required|numeric|min:0',
            'description' => 'required|string',
            'image'       => 'required|image|mimes:jpeg,png,jpg|max:5120'
        ]);
        
        $imageData = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            // Read file content as binary string
            $imageData = file_get_contents($file->getRealPath());
        }

        Product::create([
            'name'        => $request->name,
            'category'    => $request->category,
            'stock'       => $request->stock,
            'price_200g'  => $request->price_200g,
            'price_500g'  => $request->price_500g,
            'price_1kg'   => $request->price_1kg,
            'description' => $request->description,
            'image'       => $imageData // Store binary
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

        if (!$request->has('name')) {
             return back()->withErrors(['image' => 'Gagal: File terlalu besar (Melebihi batas server).'])->withInput();
        }

        $request->validate([
            'name'        => 'required|string|max:100',
            'category'    => 'required|in:biji,bubuk',
            'stock'       => 'required|numeric|min:0',
            'price_200g'  => 'required|numeric|min:0',
            'price_500g'  => 'required|numeric|min:0',
            'price_1kg'   => 'required|numeric|min:0',
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:5120'
        ]);

        $data = $request->except(['image', 'has_image_upload']);

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            if (!$file->isValid()) {
                return back()->withErrors(['image' => 'Upload error: ' . $file->getErrorMessage()])->withInput();
            }

            // Read binary
            $imageData = file_get_contents($file->getRealPath());
            $data['image'] = $imageData;
        }

        $product->update($data);

        return redirect()->route('menu.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('menu.index')->with('success', 'Produk berhasil dihapus.');
    }
    
    public function showImage($id)
    {
        $product = Product::findOrFail($id);
        
        if (!$product->image) {
            // Return 404 or default image? Let's return 404 so UI fallback handles it
            return abort(404);
        }

        return response($product->image)
            ->header('Content-Type', 'image/jpeg'); // Default to jpeg, typically browsers handle mixed types fine
    }
}
