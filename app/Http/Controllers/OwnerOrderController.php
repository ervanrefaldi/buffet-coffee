<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OwnerOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items.product'])
            ->where('status', 'menunggu_pembayaran')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('owner.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['user', 'items.product', 'transaction'])
            ->where('orders_id', $id)
            ->firstOrFail();
            
        return response()->json($order);
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::where('orders_id', $id)->firstOrFail();
        
        $request->validate([
            'status' => 'required|in:menunggu_pembayaran,dibayar'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        // Jika status diubah ke 'dibayar', buat record transaksi otomatis
        if ($request->status === 'dibayar') {
            // Cek apakah transaksi sudah ada untuk order ini (cegah duplikat)
            $exists = \App\Models\Transaction::where('orders_id', $order->orders_id)->exists();
            
            if (!$exists) {
                // Generate TRX code: TRX-YYYYMMDD-XXX
                $today = date('Ymd');
                $prefix = "TRX-{$today}-";
                
                $lastTrx = \App\Models\Transaction::where('transaction_code', 'like', "{$prefix}%")
                    ->orderBy('transaction_code', 'desc')
                    ->first();

                $nextSequence = 1;
                if ($lastTrx) {
                    $parts = explode('-', $lastTrx->transaction_code);
                    $lastSeq = (int) end($parts);
                    $nextSequence = $lastSeq + 1;
                }

                $trxCode = $prefix . str_pad($nextSequence, 3, '0', STR_PAD_LEFT);

                \App\Models\Transaction::create([
                    'orders_id' => $order->orders_id,
                    'transaction_code' => $trxCode,
                    'payment_method' => 'WHATSAPP', 
                    'transaction_date' => now(),
                    'status' => 'dibayar',
                    'created_at' => now(),
                ]);
            }
        }

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $order = Order::where('orders_id', $id)->firstOrFail();
        $order->delete();

        return back()->with('success', 'Pesanan berhasil dihapus.');
    }
}
