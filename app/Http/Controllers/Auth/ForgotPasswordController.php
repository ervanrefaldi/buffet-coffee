<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function showForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = DB::table('users')->where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan']);
        }

        // Generate token
        $token = Str::random(60);

        // Simpan token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]);

        // Kirim email
        Mail::raw(
            "Klik link ini untuk reset password:\n\n" . url('/reset-password/' . $token),
            function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('Reset Password - Bufet Coffee');
            }
        );

        return back()->with('success', 'Link reset password telah dikirim ke email Anda.');
    }
}
