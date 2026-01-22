<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login')->with('error', 'Silakan login untuk melihat keranjang.');
        }

        // Sinkronisasi otomatis dengan Auth Laravel jika session kustom ada
        if (!\Illuminate\Support\Facades\Auth::check()) {
            \Illuminate\Support\Facades\Auth::loginUsingId(session('user_id'));
        }

        $user = DB::table('users')->where('users_id', session('user_id'))->first();
        $cartItems = Cart::with('product')
            ->where('user_id', session('user_id'))
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.cart', compact('cartItems', 'user'));
    }

    public function store(Request $request)
    {
        if (!session()->has('user_id')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Sinkronisasi otomatis
        if (!\Illuminate\Support\Facades\Auth::check()) {
            \Illuminate\Support\Facades\Auth::loginUsingId(session('user_id'));
        }

        $request->validate([
            'products_id' => 'required|exists:products,products_id',
            'variant' => 'required|in:200g,500g,1kg',
            'quantity' => 'required|integer|min:1',
        ]);

        // Check if item with same variant already in cart
        $existingItem = Cart::where('user_id', session('user_id'))
            ->where('products_id', $request->products_id)
            ->where('variant', $request->variant)
            ->first();

        if ($existingItem) {
            $existingItem->increment('quantity', $request->quantity);
        } else {
            Cart::create([
                'user_id' => session('user_id'),
                'products_id' => $request->products_id,
                'variant' => $request->variant,
                'quantity' => $request->quantity,
            ]);
        }

        return response()->json(['success' => 'Produk berhasil ditambahkan ke keranjang.']);
    }

    public function update(Request $request, $id)
    {
        $cartItem = Cart::with('product')->where('carts_id', $id)->where('user_id', session('user_id'))->firstOrFail();
        
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        // Stock validation
        $itemWeightKg = 0;
        if ($cartItem->variant == '200g') $itemWeightKg = 0.2;
        elseif ($cartItem->variant == '500g') $itemWeightKg = 0.5;
        elseif ($cartItem->variant == '1kg') $itemWeightKg = 1.0;

        $totalRequestedWeight = $itemWeightKg * $request->quantity;

        // Note: This check only considers the current cart item's weight. 
        // A more robust check would sum weights for all cart items of the same product.
        if ($cartItem->product->stock < $totalRequestedWeight) {
            return response()->json([
                'error' => "Stok tidak mencukupi. Tersedia: {$cartItem->product->stock} Kg"
            ], 422);
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return response()->json(['success' => 'Jumlah berhasil diperbarui.']);
    }

    public function destroy($id)
    {
        $cartItem = Cart::where('carts_id', $id)->where('user_id', session('user_id'))->firstOrFail();
        $cartItem->delete();

        return back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }
}
