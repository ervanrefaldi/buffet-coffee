<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class OwnerTransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['order.user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('owner.transactions.index', compact('transactions'));
    }

    public function show($id)
    {
        $transaction = Transaction::with(['order.user', 'order.items.product'])
            ->where('transactions_id', $id)
            ->firstOrFail();
            
        return response()->json($transaction);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:dibayar,diproses,dikirim,selesai'
        ]);

        $transaction = Transaction::where('transactions_id', $id)->firstOrFail();
        $transaction->update(['status' => $request->status]);

        return back()->with('success', 'Status transaksi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $transaction = Transaction::where('transactions_id', $id)->firstOrFail();
        // Since Transaction model doesn't use SoftDeletes, this is a hard delete.
        $transaction->delete();

        return back()->with('success', 'Transaksi berhasil dihapus permanen dari database.');
    }
}
