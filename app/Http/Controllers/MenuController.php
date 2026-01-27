<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function checkout($id)
    {
        $product = Product::findOrFail($id);
        
        // Check if user is logged in
        if (!session()->has('user_id')) {
            return redirect('/login')->with('error', 'Silakan login untuk memesan.');
        }

        $user = DB::table('users')->where('users_id', session('user_id'))->first();

        // Handle case where session exists but user is deleted (stale session)
        if (!$user) {
            session()->flush();
            return redirect('/login')->with('error', 'Sesi anda telah berakhir. Silakan login kembali.');
        }
        
        // Simple membership check
        $isMember = ($user->role === 'membership' || $user->membership === 'membership');

        // Fetch all products (include current one to allow different variant selection)
        $allProducts = Product::all();

        return view('pages.checkout', compact('product', 'user', 'isMember', 'allProducts'));
    }
}
