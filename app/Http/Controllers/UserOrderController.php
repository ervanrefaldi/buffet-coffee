<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserOrderController extends Controller
{
    public function index()
    {
        if (!session()->has('user_id')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $orders = Order::with(['items.product', 'transaction'])
            ->where('user_id', session('user_id'))
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.orders.index', compact('orders'));
    }

    public function invoice($id)
    {
        if (!session()->has('user_id')) {
            return redirect('/login');
        }

        $order = Order::with(['items.product', 'user'])
            ->where('orders_id', $id)
            ->where('user_id', session('user_id'))
            ->firstOrFail();

        // Check if status is eligible for invoice (dibayar, diproses, selesai)
        $eligibleStatuses = ['dibayar', 'diproses', 'dikirim', 'selesai'];
        if (!in_array($order->status, $eligibleStatuses)) {
            return back()->with('error', 'Invoice hanya tersedia untuk pesanan yang sudah dibayar.');
        }

        return view('user.orders.invoice', compact('order'));
    }

    public function destroy($id)
    {
        if (!session()->has('user_id')) {
            return redirect('/login');
        }

        $order = Order::where('orders_id', $id)
            ->where('user_id', session('user_id'))
            ->firstOrFail();

        // Hanya pesanan 'menunggu_pembayaran' yang bisa dibatalkan user
        if ($order->status !== 'menunggu_pembayaran') {
            return back()->with('error', 'Pesanan yang sudah dibayar/diproses tidak dapat dibatalkan.');
        }

        // Hapus item pesanan terkait
        $order->items()->delete();
        
        // Hapus pesanan utama
        $order->delete();

        return back()->with('success', 'Pesanan berhasil dibatalkan dan dihapus.');
    }
}
