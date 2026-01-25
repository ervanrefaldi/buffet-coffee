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

        // Detect POST Size Violation (Payload too large causes empty request)
        if (empty($request->all()) && empty($request->files->all())) {
            return back()->withErrors(['image' => 'Gagal: File terlalu besar (Melebihi batas server ' . ini_get('post_max_size') . '). Silakan kompres foto Anda.']);
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

        // Check for Silent Upload Failure (Input ada tapi File tidak sampai)
        if ($request->input('has_image_upload') == '1' && !$request->hasFile('image')) {
            return back()->withErrors(['image' => 'Gagal upload: File terdeteksi tapi ditolak server (Ukuran terlalu besar).'])->withInput();
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_' . \Illuminate\Support\Str::slug($name) . '.' . $extension;
            
            // STRTEGI BARU: Upload ke Primary Path dulu, baru copy ke yang lain
            // Path Primary: DOCUMENT_ROOT (jika ada) atau public_path() default
            $primaryPath = public_path('images/products');
            if (isset($_SERVER['DOCUMENT_ROOT']) && !empty($_SERVER['DOCUMENT_ROOT'])) {
                $primaryPath = $_SERVER['DOCUMENT_ROOT'] . '/images/products';
            }

            // Path Sekunder: Lokasi lain yang mungkin valid (untuk backup/compatibility)
            $backupPaths = [];
            $backupPaths[] = public_path('images/products');
            if (file_exists(base_path('../public_html'))) {
                $backupPaths[] = base_path('../public_html/images/products');
            }
            // Remove primary from backup to avoid redundant copy
            $backupPaths = array_unique(array_diff($backupPaths, [$primaryPath]));

            // 1. Eksekusi MOVE ke Primary (Wajib Sukses)
            if (!file_exists($primaryPath)) { @mkdir($primaryPath, 0755, true); }
            
            $file->move($primaryPath, $filename);
            
            // Fix Permission Primary
            try { @chmod($primaryPath . '/' . $filename, 0644); } catch (\Exception $e) {}

            // 2. Copy ke Backup Paths (Best Effort)
            foreach ($backupPaths as $bPath) {
                if (!file_exists($bPath)) { @mkdir($bPath, 0755, true); }
                @copy($primaryPath . '/' . $filename, $bPath . '/' . $filename);
                try { @chmod($bPath . '/' . $filename, 0644); } catch (\Exception $e) {}
            }

            $data['image'] = 'images/products/' . $filename;

            // 3. Hapus gambar lama (Cleanup)
            if ($product->image) {
                $allPaths = array_merge([$primaryPath], $backupPaths);
                foreach ($allPaths as $path) {
                    $oldFile = $path . '/' . basename($product->image);
                    if (file_exists($oldFile)) {
                        @unlink($oldFile);
                    }
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
