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

        // Role-based Redirect
        if (in_array($user->role, ['owner', 'admin'])) {
            return redirect('/owner/dashboard');
        }

        return redirect('/');
    }
}
