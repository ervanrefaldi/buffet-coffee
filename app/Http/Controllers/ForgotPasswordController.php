<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    // 1. Tampilkan form untuk memasukkan email yang lupa passwordnya
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    // 2. Proses pengiriman kode OTP
    public function sendCode(Request $request)
    {
        // Validasi format email dan pastikan email terdaftar di tabel users
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Silakan masukkan alamat email Anda.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Maaf, email tersebut tidak terdaftar di sistem kami.'
        ]);

        $email = $request->email;
        $code = rand(1000, 9999); // Membuat kode acak 4 digit

        // Simpan data di session agar bisa diverifikasi di halaman selanjutnya
        session([
            'reset_code' => $code,
            'reset_email' => $email,
            'reset_expiry' => now()->addMinutes(10) // Kode berlaku 10 menit
        ]);

        // LOGGING: Catat ke log agar user bisa melihat kodenya jika SMTP belum aktif
        Log::info("==========================================");
        Log::info("PERMINTAAN RESET PASSWORD");
        Log::info("Email Target: " . $email);
        Log::info("Kode OTP: " . $code);
        Log::info("==========================================");

        // Kirim Email
        try {
            Mail::raw("Halo,\n\nKami menerima permintaan untuk mereset password akun Anda.\n\nKode verifikasi Anda adalah: $code\n\nMasukkan kode ini di website untuk melanjutkan proses reset password. Kode ini akan kadaluarsa dalam 10 menit.\n\nJika Anda tidak merasa melakukan permintaan ini, silakan abaikan email ini.", function ($message) use ($email) {
                $message->to($email)
                        ->subject('Kode Verifikasi Reset Password - Bufet Coffee');
            });
        } catch (\Exception $e) {
            // Jika gagal kirim email (misal di localhost tanpa SMTP), sistem tetap lanjut ke halaman verifikasi
            // User bisa cek kode di file storage/logs/laravel.log
            Log::error("Gagal mengirim email ke $email: " . $e->getMessage());
        }

        // Redirect ke halaman verifikasi kode
        return redirect()->route('verify-code')->with('success', 'Kode reset telah dikirim ke email: ' . $email);
    }

    // 3. Tampilkan form verifikasi kode
    public function showVerifyForm()
    {
        // Pastikan ada email di session, jika tidak balik ke halaman awal
        if (!session()->has('reset_email')) {
            return redirect()->route('forgot-password');
        }
        return view('auth.verify-code');
    }

    // 4. Proses verifikasi kode yang diinput user
    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:4',
        ], [
            'code.required' => 'Silakan masukkan kode 4 digit.',
            'code.digits' => 'Kode harus berupa 4 digit angka.'
        ]);

        $inputCode = $request->code;
        $sessionCode = session('reset_code');
        $expiry = session('reset_expiry');

        // Cek kecocokan kode dan waktu kadaluarsa
        if ($inputCode == $sessionCode && now()->lessThan($expiry)) {
            // Tandai sudah terverifikasi di session
            session(['code_verified' => true]);
            return redirect()->route('reset-password');
        } else {
            return back()->withErrors(['code' => 'Kode yang Anda masukkan salah atau sudah kadaluarsa. Silakan cek kembali email Anda.']);
        }
    }

    // 5. Tampilkan form input password baru
    public function showResetForm()
    {
        // Pastikan kode sudah diverifikasi
        if (!session('code_verified')) {
            return redirect()->route('forgot-password');
        }
        return view('auth.reset-password');
    }

    // 6. Proses update password ke database
    public function resetPassword(Request $request)
    {
        if (!session('code_verified')) {
            return redirect()->route('forgot-password');
        }

        $request->validate([
            'password' => 'required|min:8|confirmed',
        ], [
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        $email = session('reset_email');
        
        // Cari user berdasarkan email yang tersimpan di session
        $user = User::where('email', $email)->first();

        if ($user) {
            // Update password (Eloquent akan otomatis melakukan hashing jika diatur di model User)
            $user->update([
                'password' => $request->password,
            ]);
            
            // Hapus data reset dari session setelah berhasil
            session()->forget(['reset_code', 'reset_email', 'reset_expiry', 'code_verified']);

            return redirect('/login')->with('success', 'Password Anda berhasil diperbarui. Silakan login dengan password baru.');
        }

        return redirect()->route('forgot-password')->withErrors(['email' => 'Gagal mereset password. User tidak ditemukan.']);
    }
}