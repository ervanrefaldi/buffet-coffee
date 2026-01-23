<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\OrderItem;
use Carbon\Carbon;

class OwnerReportController extends Controller
{
    public function index(Request $request)
    {
        // Default to current month if dates not provided
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());

        // Parse dates for query
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        // 1. Transactions Query
        $transactions = Transaction::with(['order.user', 'order.items.product'])
            ->whereBetween('created_at', [$start, $end])
            ->orderBy('created_at', 'desc')
            ->get();

        // 2. Summary Metrics
        $totalRevenue = 0;
        $totalTransactions = $transactions->count();
        
        foreach ($transactions as $trx) {
            $totalRevenue += $trx->order->total_price ?? 0;
        }

        $avgTransaction = $totalTransactions > 0 ? $totalRevenue / $totalTransactions : 0;

        // 3. Best Selling Products (Top 5)
        // We need to look at order items within the date range
        $topProducts = OrderItem::select('products_id', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(subtotal) as total_sales'))
            ->whereHas('order', function($query) use ($start, $end) {
                $query->whereBetween('created_at', [$start, $end])
                      ->where('status', 'dibayar'); // Only count paid orders
            })
            ->with('product')
            ->groupBy('products_id')
            ->orderBy('total_qty', 'desc')
            ->limit(5)
            ->get();

        return view('owner.laporan.index', compact(
            'transactions',
            'totalRevenue',
            'totalTransactions',
            'avgTransaction',
            'topProducts',
            'startDate',
            'endDate'
        ));
    }

    public function exportExcel(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());

        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        $transactions = Transaction::with(['order.user'])
            ->whereBetween('created_at', [$start, $end])
            ->orderBy('created_at', 'desc')
            ->get();

        $fileName = 'Laporan_Penjualan_' . $startDate . '_to_' . $endDate . '.csv';

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Kode TRX', 'Tanggal', 'Pembeli', 'Status Member', 'Total', 'Status');

        $callback = function() use($transactions, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($transactions as $trx) {
                fputcsv($file, array(
                    $trx->transaction_code,
                    $trx->created_at->format('d M Y, H:i'),
                    $trx->order->user->name ?? 'Guest',
                    strtoupper($trx->order->user->membership ?? 'regular'),
                    $trx->order->total_price ?? 0,
                    strtoupper($trx->status)
                ));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportWord(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());

        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        $transactions = Transaction::with(['order.user'])
            ->whereBetween('created_at', [$start, $end])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalRevenue = 0;
        foreach ($transactions as $trx) {
            $totalRevenue += $trx->order->total_price ?? 0;
        }

        $fileName = 'Laporan_Penjualan_' . $startDate . '_to_' . $endDate . '.doc';

        // Word Content as HTML
        $html = "
        <html xmlns:v='urn:schemas-microsoft-com:vml' xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns:m='http://schemas.microsoft.com/office/2004/12/omml' xmlns='http://www.w3.org/TR/REC-html40'>
        <head><meta charset='utf-8'><title>Laporan Penjualan</title></head>
        <body>
            <div style='text-align: center;'>
                <h1>BUFET COFFEE</h1>
                <h2>LAPORAN PENJUALAN</h2>
                <p>Periode: " . date('d M Y', strtotime($startDate)) . " - " . date('d M Y', strtotime($endDate)) . "</p>
                <hr>
            </div>
            
            <h3>Ringkasan Performa</h3>
            <table border='0' cellpadding='5'>
                <tr><td><b>Total Pendapatan:</b></td><td>Rp " . number_format($totalRevenue, 0, ',', '.') . "</td></tr>
                <tr><td><b>Total Transaksi:</b></td><td>" . $transactions->count() . " Trx</td></tr>
            </table>

            <h3>Riwayat Transaksi</h3>
            <table border='1' cellpadding='5' cellspacing='0' style='width: 100%; border-collapse: collapse;'>
                <thead>
                    <tr style='background-color: #f2f2f2;'>
                        <th>Kode TRX</th>
                        <th>Tanggal</th>
                        <th>Pembeli</th>
                        <th>Status Member</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>";
        
        foreach ($transactions as $trx) {
            $html .= "
                    <tr>
                        <td>{$trx->transaction_code}</td>
                        <td>" . $trx->created_at->format('d M Y, H:i') . "</td>
                        <td>" . ($trx->order->user->name ?? 'Guest') . "</td>
                        <td>" . strtoupper($trx->order->user->membership ?? 'regular') . "</td>
                        <td>Rp " . number_format($trx->order->total_price ?? 0, 0, ',', '.') . "</td>
                        <td>" . strtoupper($trx->status) . "</td>
                    </tr>";
        }

        $html .= "
                </tbody>
            </table>
            <p style='text-align: right; font-size: 10px; margin-top: 50px;'>Dicetak pada: " . now()->format('d M Y, H:i') . "</p>
        </body>
        </html>";

        return response($html)
            ->header('Content-Type', 'application/msword')
            ->header('Content-Disposition', "attachment; filename=$fileName");
    }
}
