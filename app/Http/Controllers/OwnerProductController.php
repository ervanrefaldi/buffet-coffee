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
        Log::info('Menu Store Files', $request->allFiles());
        
        $request->validate([
            'name'        => 'required|string|max:100',
            'category'    => 'required|in:biji,bubuk',
            'stock'       => 'required|numeric|min:0',
            'price_200g'  => 'required|numeric|min:0',
            'price_500g'  => 'required|numeric|min:0',
            'price_1kg'   => 'required|numeric|min:0',
            'description' => 'required|string',
            'image'       => 'required|image|mimes:jpeg,png,jpg|max:1024'
        ], [
            'image.required' => 'Foto produk wajib diupload. (Jika sudah pilih foto tapi masih error, ukuran file mungkin terlalu besar, max 1MB).',
            'image.uploaded' => 'Gagal mengupload gambar. Ukuran file terlalu besar (Maksimal server 1MB-2MB).',
            'image.max'      => 'Ukuran gambar tidak boleh lebih dari 1MB.',
            'image.image'    => 'File harus berupa gambar.',
            'image.mimes'    => 'Format harus jpg, jpeg, atau png.'
        ]);
        
        $imagePath = null;
        // Standard upload logic
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/products'), $filename);
            $imagePath = 'images/products/' . $filename;
        }

        Product::create([
            'name'        => $request->name,
            'category'    => $request->category,
            'stock'       => $request->stock,
            'price_200g'  => $request->price_200g,
            'price_500g'  => $request->price_500g,
            'price_1kg'   => $request->price_1kg,
            'description' => $request->description,
            'image'       => $imagePath
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

        // Detect POST Size Violation (Cek field mandatory 'name')
        if (!$request->has('name')) {
             return back()->withErrors(['image' => 'Gagal: File terlalu besar (Melebihi batas server ' . ini_get('post_max_size') . '). Mohon kompres foto di bawah 5MB.'])->withInput();
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
        ], [
            'image.max' => 'Ukuran gambar maksimal 5MB.'
        ]);

        $data = $request->except(['image', 'has_image_upload']);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_' . \Illuminate\Support\Str::slug($name) . '.' . $extension;
            
            // Tentukan folder tujuan (Multi-path strategy)
            $paths = [];
            $paths[] = public_path('images/products');
            if (isset($_SERVER['DOCUMENT_ROOT']) && !empty($_SERVER['DOCUMENT_ROOT'])) $paths[] = $_SERVER['DOCUMENT_ROOT'] . '/images/products';
            if (file_exists(base_path('../public_html'))) $paths[] = base_path('../public_html/images/products');
            $paths = array_unique($paths);

            // Upload ke SEMUA lokasi
            foreach ($paths as $path) {
                if (!file_exists($path)) @mkdir($path, 0755, true);
                @copy($file->getRealPath(), $path . '/' . $filename);
                try { @chmod($path . '/' . $filename, 0644); } catch (\Exception $e) {}
            }

            $data['image'] = 'images/products/' . $filename;

            // Hapus file lama di semua lokasi
            if ($product->image) {
                foreach ($paths as $path) {
                    $oldFile = $path . '/' . basename($product->image);
                    if (file_exists($oldFile)) @unlink($oldFile);
                }
            }
        }

        $product->update($data);

        return redirect()->route('menu.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        $product->delete();

        return redirect()->route('menu.index')->with('success', 'Produk berhasil dihapus.');
    }
}
