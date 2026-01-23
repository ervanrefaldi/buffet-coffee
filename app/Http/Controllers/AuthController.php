<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * REGISTER
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8'],
            'phone' => ['required', 'numeric'],
        ], [
            'name.regex' => 'Nama tidak boleh mengandung angka.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.min' => 'Password minimal 8 karakter.',
            'phone.numeric' => 'Nomor telepon hanya boleh angka.',
        ]);

        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => 'pelanggan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil, silakan login.');
    }

    /**
     * LOGIN
     */
    public function login(Request $request)
    {
        // validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // ambil user dari database
        $user = DB::table('users')
            ->where('email', $request->email)
            ->first();

        // cek user & password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'Email atau password salah.'
            ]);
        }

        // SIMPAN DATA USER KE SESSION & SYNC DENGAN AUTH LARAVEL
        Auth::loginUsingId($user->users_id);

        session([
            'user_id'    => $user->users_id,
            'user_name'  => $user->name,
            'user_email' => $user->email,
            'user_phone' => $user->phone,
            'user_role'  => $user->role,
            'user_membership' => $user->membership ?? 'regular',
        ]);

        // Role-based Redirect & Welcome Message
        $role = strtolower(trim($user->role));

        // 1. OWNER / ADMIN -> Dashboard Owner
        if ($role === 'owner' || $role === 'admin') {
            return redirect()->route('owner.dashboard')->with('success', 'Selamat datang kembali, Owner!');
        }

        // 2. MEMBER -> Home (Cek kolom membership)
        $membership = strtolower(trim($user->membership ?? ''));
        if ($membership && $membership !== 'regular' && $membership !== 'none') {
             return redirect('/')->with('success', 'Selamat datang kembali, Member ' . $user->name . '!');
        }

        // 3. PELANGGAN (Default) -> Home
        return redirect('/')->with('success', 'Selamat datang kembali, ' . $user->name . '!');
    }
}
