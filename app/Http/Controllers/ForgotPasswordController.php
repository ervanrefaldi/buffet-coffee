<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    public function sendCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $email = $request->email;
        $code = rand(1000, 9999); // 4 digit random code

        // Simpan kode di session dengan expiry (misal 10 menit)
        session(['reset_code' => $code, 'reset_email' => $email, 'reset_expiry' => now()->addMinutes(10)]);

        // Kirim email
        Mail::raw("Kode reset password Anda: $code", function ($message) use ($email) {
            $message->to($email)->subject('Kode Reset Password');
        });

        return redirect()->route('verify-code')->with('success', 'Kode telah dikirim ke email Anda.');
    }

    public function showVerifyForm()
    {
        return view('auth.verify-code');
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:4',
        ]);

        $code = $request->code;
        $sessionCode = session('reset_code');
        $expiry = session('reset_expiry');

        if ($code == $sessionCode && now()->lessThan($expiry)) {
            session(['code_verified' => true]);
            return redirect()->route('reset-password');
        } else {
            return back()->withErrors(['code' => 'Kode tidak valid atau sudah expired.']);
        }
    }

    public function showResetForm()
    {
        if (!session('code_verified')) {
            return redirect()->route('forgot-password');
        }
        return view('auth.reset-password');
    }

    public function resetPassword(Request $request)
    {
        if (!session('code_verified')) {
            return redirect()->route('forgot-password');
        }

        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $email = session('reset_email');
        $user = DB::table('users')->where('email', $email)->first();

        if ($user) {
            DB::table('users')->where('email', $email)->update([
                'password' => Hash::make($request->password),
            ]);
        }

        // Clear session
        session()->forget(['reset_code', 'reset_email', 'reset_expiry', 'code_verified']);

        return redirect('/login')->with('success', 'Password berhasil direset. Silakan login.');
    }
}