<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Simulate a transaction and decrement stock.
     * This is a placeholder for actual payment gateway integration.
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'items'             => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,products_id',
            'items.*.variant'    => 'required|in:200g,500g,1kg',
            'items.*.quantity'   => 'required|integer|min:1',
            'phone'             => 'required|string',
            'address'           => 'required|string',
        ]);

        $userId = session('user_id');
        $dbUser = DB::table('users')->where('users_id', $userId)->first();
        if (!$dbUser) {
            return redirect('/login')->with('error', 'Sesi anda telah berakhir.');
        }

        $isMember = ($dbUser->role === 'membership');
        $totalWeight = 0;
        $subtotal = 0;
        $itemsData = [];

        foreach ($request->items as $itemInput) {
            $product = Product::findOrFail($itemInput['product_id']);
            $variant = $itemInput['variant'];
            $quantity = $itemInput['quantity'];

            $deductionPerItem = match($variant) {
                '200g' => 0.2,
                '500g' => 0.5,
                '1kg' => 1.0,
                default => 0.2
            };
            $pricePerItem = $product->getPriceByVariant($variant);
            
            $itemWeight = $deductionPerItem * $quantity;
            $itemSubtotal = $pricePerItem * $quantity;

            if ($product->stock < $itemWeight) {
                return back()->with('error', "Stok {$product->name} tidak mencukupi.");
            }

            $totalWeight += $itemWeight;
            $subtotal += $itemSubtotal;
            
            $itemsData[] = [
                'product' => $product,
                'variant' => $variant,
                'quantity' => $quantity,
                'price' => $pricePerItem,
                'subtotal' => $itemSubtotal,
                'weight' => $itemWeight
            ];
        }

        $discountAmount = $isMember ? ($subtotal * 0.03) : 0;
        $totalPrice = $subtotal - $discountAmount;

        // Generate Order Code
        $today = date('Ymd');
        $prefix = "ORD-{$today}-";
        $lastOrder = DB::table('orders')->where('order_code', 'like', "{$prefix}%")->orderBy('order_code', 'desc')->first();
        $nextSequence = 1;
        if ($lastOrder) {
            $parts = explode('-', $lastOrder->order_code);
            $lastSeq = (int) end($parts);
            $nextSequence = $lastSeq + 1;
        }
        $orderCode = $prefix . str_pad($nextSequence, 3, '0', STR_PAD_LEFT);

        // Database Transaction
        DB::transaction(function () use ($itemsData, $totalWeight, $request, $totalPrice, $orderCode, $userId, $discountAmount) {
            $order = \App\Models\Order::create([
                'user_id'          => $userId,
                'order_code'       => $orderCode,
                'total_price'      => $totalPrice,
                'total_weight'     => $totalWeight,
                'discount'         => $discountAmount,
                'shipping_address' => $request->address,
                'status'           => 'menunggu_pembayaran',
            ]);

            foreach ($itemsData as $data) {
                $data['product']->decrement('stock', $data['weight']);
                
                \App\Models\OrderItem::create([
                    'orders_id'   => $order->orders_id,
                    'products_id' => $data['product']->products_id,
                    'quantity'    => $data['quantity'],
                    'variant'     => $data['variant'],
                    'price'       => $data['price'],
                    'subtotal'    => $data['subtotal'],
                ]);
            }

            // Upgrade Membership Logic
            if (session('user_role') === 'pelanggan' && $totalWeight >= 100) {
                DB::table('users')->where('users_id', $userId)->update(['role' => 'membership']);
                session(['user_role' => 'membership']);
            }
        });

        // WhatsApp Message Generation
        $waNumber = "6282118189789"; 
        $hour = date('H');
        $greeting = ($hour < 11) ? 'pagi' : (($hour < 15) ? 'siang' : (($hour < 19) ? 'sore' : 'malam'));
        
        $userName = session('user_name');
        $userPhone = $request->phone;
        
        $message = "Selamat {$greeting}, Admin.\n\n";
        $message .= "Saya ingin melakukan pemesanan dengan detail sebagai berikut:\n\n";
        $message .= "Kode Pemesanan   : {$orderCode}\n";
        $message .= "Role User        : " . ($isMember ? 'Member' : 'Pelanggan') . "\n";
        $message .= "Nama Lengkap      : {$userName}\n";
        $message .= "Nomor Telepon     : {$userPhone}\n";
        $message .= "Alamat Pengiriman : {$request->address}\n\n";
        $message .= "Detail Pesanan:\n";
        
        foreach ($itemsData as $data) {
            $message .= "- {$data['product']->name} ({$data['variant']}) x {$data['quantity']} : Rp " . number_format($data['subtotal'], 0, ',', '.') . "\n";
        }
        
        if ($isMember) {
            $message .= "\nSubtotal           : Rp " . number_format($subtotal, 0, ',', '.') . "\n";
            $message .= "Diskon Member (3%) : - Rp " . number_format($discountAmount, 0, ',', '.') . "\n";
        }
        $message .= "Total Pembayaran   : Rp " . number_format($totalPrice, 0, ',', '.') . "\n\n";
        $message .= "Mohon konfirmasi ketersediaan barang dan total akhir pembayaran.\n\n";
        $message .= "Terima kasih.";

        return redirect("https://wa.me/{$waNumber}?text=" . rawurlencode($message));
    }

    public function cartCheckoutPage()
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login')->with('error', 'Silakan login untuk checkout.');
        }

        // Sinkronisasi otomatis
        if (!\Illuminate\Support\Facades\Auth::check()) {
            \Illuminate\Support\Facades\Auth::loginUsingId(session('user_id'));
        }

        $user = DB::table('users')->where('users_id', session('user_id'))->first();
        $cartItems = \App\Models\Cart::with('product')
            ->where('user_id', session('user_id'))
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect('/cart')->with('error', 'Keranjang anda kosong.');
        }

        $isMember = ($user->role === 'membership');

        return view('pages.checkout_cart', compact('cartItems', 'user', 'isMember'));
    }

    public function processCartCheckout(Request $request)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login');
        }

        // Sinkronisasi otomatis
        if (!\Illuminate\Support\Facades\Auth::check()) {
            \Illuminate\Support\Facades\Auth::loginUsingId(session('user_id'));
        }

        $request->validate([
            'phone'   => 'required|string',
            'address' => 'required|string',
        ]);

        $userId = session('user_id');
        $cartItems = \App\Models\Cart::with('product')->where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return redirect('/menu')->with('error', 'Keranjang anda kosong.');
        }

        // --- 1. PRE-CALCULATIONS & STOCK VALIDATION ---
        $totalWeight = 0;
        $subtotal = 0;
        $itemsData = [];

        foreach ($cartItems as $item) {
            $deduction = match($item->variant) {
                '200g' => 0.2,
                '500g' => 0.5,
                '1kg' => 1.0,
                default => 0.2
            };
            
            $itemWeight = $deduction * $item->quantity;
            $itemPrice = $item->product->getPriceByVariant($item->variant);
            $itemSubtotal = $itemPrice * $item->quantity;

            if ($item->product->stock < $itemWeight) {
                return back()->with('error', "Stok {$item->product->name} tidak mencukupi.");
            }

            $totalWeight += $itemWeight;
            $subtotal += $itemSubtotal;
            $itemsData[] = [
                'product' => $item->product,
                'variant' => $item->variant,
                'quantity' => $item->quantity,
                'price' => $itemPrice,
                'subtotal' => $itemSubtotal,
                'weight' => $itemWeight
            ];
        }

        // --- 2. DISCOUNT ---
        $dbUser = DB::table('users')->where('users_id', $userId)->first();
        $isMember = ($dbUser->role === 'membership');
        $discountAmount = $isMember ? ($subtotal * 0.03) : 0;
        $totalPrice = $subtotal - $discountAmount;

        // --- 3. GENERATE ORDER CODE ---
        $today = date('Ymd');
        $prefix = "ORD-{$today}-";
        $lastOrder = DB::table('orders')->where('order_code', 'like', "{$prefix}%")->orderBy('order_code', 'desc')->first();
        $nextSequence = $lastOrder ? ((int) end(explode('-', $lastOrder->order_code)) + 1) : 1;
        $orderCode = $prefix . str_pad($nextSequence, 3, '0', STR_PAD_LEFT);

        // --- 4. DATABASE TRANSACTIONS ---
        DB::transaction(function () use ($itemsData, $totalWeight, $request, $totalPrice, $orderCode, $userId, $discountAmount) {
            
            $order = \App\Models\Order::create([
                'user_id'          => $userId,
                'order_code'       => $orderCode,
                'total_price'      => $totalPrice,
                'total_weight'     => $totalWeight,
                'discount'         => $discountAmount,
                'shipping_address' => $request->address,
                'status'           => 'menunggu_pembayaran',
            ]);

            foreach ($itemsData as $data) {
                $data['product']->decrement('stock', $data['weight']);
                
                \App\Models\OrderItem::create([
                    'orders_id'   => $order->orders_id,
                    'products_id' => $data['product']->products_id,
                    'quantity'    => $data['quantity'],
                    'variant'     => $data['variant'],
                    'price'       => $data['price'],
                    'subtotal'    => $data['subtotal'],
                ]);
            }


            // Clear Cart
            \App\Models\Cart::where('user_id', $userId)->delete();

            // Upgrade Membership
            if (session('user_role') === 'pelanggan' && $totalWeight >= 100) {
                DB::table('users')->where('users_id', $userId)->update(['role' => 'membership']);
                session(['user_role' => 'membership']);
            }
        });

        // --- 5. WHATSAPP MESSAGE ---
        $waNumber = "6282118189789";
        $hour = date('H');
        $greeting = ($hour < 11) ? 'pagi' : (($hour < 15) ? 'siang' : (($hour < 19) ? 'sore' : 'malam'));
        
        $message = "Selamat {$greeting}, Admin.\n\n";
        $message .= "Saya ingin melakukan pemesanan (Keranjang) sebagai berikut:\n\n";
        $message .= "Kode Pemesanan   : {$orderCode}\n";
        $message .= "Nama Lengkap      : " . session('user_name') . "\n";
        $message .= "Alamat Pengiriman : {$request->address}\n\n";
        $message .= "Detail Pesanan:\n";
        
        foreach ($itemsData as $data) {
            $message .= "- {$data['product']->name} ({$data['variant']}) x {$data['quantity']} : Rp " . number_format($data['subtotal'], 0, ',', '.') . "\n";
        }
        
        if ($isMember) {
            $message .= "\nSubtotal           : Rp " . number_format($subtotal, 0, ',', '.') . "\n";
            $message .= "Diskon Member (3%) : - Rp " . number_format($discountAmount, 0, ',', '.') . "\n";
        }
        $message .= "Total Pembayaran   : Rp " . number_format($totalPrice, 0, ',', '.') . "\n\n";
        $message .= "Terima kasih.";

        return redirect("https://wa.me/{$waNumber}?text=" . rawurlencode($message));
    }
}
