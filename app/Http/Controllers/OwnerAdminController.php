<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class OwnerAdminController extends Controller
{
    public function index()
    {
        // Tampilkan semua owner kecuali master owner (owner@bufet.com)
        $admins = User::where('role', 'owner')
                     ->where('email', '!=', 'owner@bufet.com')
                     ->orderBy('created_at', 'desc')
                     ->get();
        return view('owner.admin.index', compact('admins'));
    }

    public function create()
    {
        return view('owner.admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:100', 'regex:/^[a-zA-Z\s]+$/'],
            'email'    => ['required', 'email', 'unique:users,email', 'max:100'],
            'password' => ['required', 'min:8'],
            'phone'    => ['required', 'numeric'],
        ], [
            'name.regex' => 'Nama tidak boleh mengandung angka.',
            'name.max' => 'Nama maksimal 100 karakter.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.min' => 'Password minimal 8 karakter.',
            'phone.numeric' => 'Nomor telepon hanya boleh angka.',
        ]);

        User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'phone'      => $request->phone,
            'role'       => 'owner', // Menggunakan role owner
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.index')->with('success', 'Akun owner berhasil dibuat.');
    }

    public function edit($id)
    {
        // Pastikan tidak mengedit master owner via sini
        $admin = User::where('users_id', $id)
                    ->where('role', 'owner')
                    ->where('email', '!=', 'owner@bufet.com')
                    ->firstOrFail();
        return view('owner.admin.edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $admin = User::where('users_id', $id)
                    ->where('role', 'owner')
                    ->where('email', '!=', 'owner@bufet.com')
                    ->firstOrFail();

        $request->validate([
            'name'     => ['required', 'string', 'max:100', 'regex:/^[a-zA-Z\s]+$/'],
            'email'    => ['required', 'email', "unique:users,email,{$id},users_id", 'max:100'],
            'password' => ['nullable', 'min:8'],
            'phone'    => ['required', 'numeric'],
        ], [
            'name.regex' => 'Nama tidak boleh mengandung angka.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.min' => 'Password minimal 8 karakter.',
            'phone.numeric' => 'Nomor telepon hanya boleh angka.',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'updated_at' => now(),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return redirect()->route('admin.index')->with('success', 'Data owner berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $admin = User::where('users_id', $id)
                    ->where('role', 'owner')
                    ->where('email', '!=', 'owner@bufet.com')
                    ->firstOrFail();
        $admin->delete();

        return redirect()->route('admin.index')->with('success', 'Akun owner berhasil dihapus.');
    }
}
