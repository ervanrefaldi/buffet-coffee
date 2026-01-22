<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;

class OwnerDashboardController extends Controller
{
    public function index()
    {
        // 1. Statistics Cards
        $totalActiveEvents = DB::table('events')
            ->where('end_date', '>=', Carbon::today())
            ->count();

        $totalMenu = Product::count();

        $totalStaff = User::whereIn('role', ['owner', 'admin'])->count();

        // Revenue Today (Yesterday's and Today's compared?)
        // Let's just sum total_price from transactions created today
        $todayRevenue = Transaction::join('orders', 'transactions.orders_id', '=', 'orders.orders_id')
            ->whereDate('transactions.created_at', Carbon::today())
            ->sum('orders.total_price');

        // 2. Weekly Chart Data (Last 7 Days)
        $labels = [];
        $orderCounts = [];
        $transactionCounts = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels[] = $date->format('D, d M');

            // Blue: Pending Orders created on that day
            $orderCounts[] = Order::whereDate('created_at', $date)
                ->where('status', 'menunggu_pembayaran')
                ->count();

            // Green: Transactions created on that day (Paid orders)
            $transactionCounts[] = Transaction::whereDate('created_at', $date)->count();
        }

        return view('owner.dashboard', compact(
            'totalActiveEvents',
            'totalMenu',
            'totalStaff',
            'todayRevenue',
            'labels',
            'orderCounts',
            'transactionCounts'
        ));
    }
}
