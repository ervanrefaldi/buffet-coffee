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
            Log::info('Updating Product Image: File detected', ['name' => $file->getClientOriginalName(), 'size' => $file->getSize()]);

            if (!$file->isValid()) {
                Log::error('Updating Product Image: File invalid', ['error' => $file->getErrorMessage()]);
                return back()->withErrors(['image' => 'Upload error: ' . $file->getErrorMessage()])->withInput();
            }

            // Read binary
            $imageData = file_get_contents($file->getRealPath());
            
            // Explicitly assign binary data
            $product->image = $imageData;
            
            Log::info('Updating Product Image: Binary data assigned to model', ['length' => strlen($product->image)]);
            error_log('DEBUG: Binary data assigned. Length: ' . strlen($product->image));
        } else {
            Log::info('Updating Product Image: No file detected in request');
        }

        // Fill other data
        $product->fill($request->except(['image', 'has_image_upload']));

        if ($product->isDirty('image')) {
            Log::info('Updating Product Image: Model is dirty (image changed). Saving...');
            error_log('DEBUG: Model is dirty. Saving...');
        } else {
            Log::info('Updating Product Image: Model is clean (image NOT changed).');
            error_log('DEBUG: Model is clean.');
        }

        $saved = $product->save();
        
        Log::info('Updating Product Image: Save result', ['success' => $saved]);
        error_log('DEBUG: Save result: ' . ($saved ? 'TRUE' : 'FALSE'));

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
