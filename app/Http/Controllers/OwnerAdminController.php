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
        // Tampilkan semua owner dan admin kecuali master owner (owner@bufet.com)
        $admins = User::whereIn('role', ['owner', 'admin'])
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
            'role'     => ['required', 'in:owner,admin'],
        ], [
            'name.regex' => 'Nama tidak boleh mengandung angka.',
            'name.max' => 'Nama maksimal 100 karakter.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.min' => 'Password minimal 8 karakter.',
            'phone.numeric' => 'Nomor telepon hanya boleh angka.',
            'role.required' => 'Role harus dipilih.',
            'role.in' => 'Role harus owner atau admin.',
        ]);

        try {
            $this->createUser($request);
        } catch (\Illuminate\Database\QueryException $e) {
            // Self-healing: Catch Enum/Data Truncated error (Code 1265)
            // or General Error (01000) related to role column
            if (str_contains($e->getMessage(), "Data truncated for column 'role'") || $e->getCode() == '01000') {
                
                // 1. Attempt to FIX the database schema automatically
                try {
                    DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('owner', 'pelanggan', 'membership', 'admin') NOT NULL");
                    
                    // 2. Refresh the Trigger as well (important for ID generation)
                    DB::unprepared("DROP TRIGGER IF EXISTS trg_users_generate_id");
                    DB::unprepared("
                        CREATE TRIGGER trg_users_generate_id
                        BEFORE INSERT ON users
                        FOR EACH ROW
                        BEGIN
                            DECLARE role_code CHAR(2);
                            DECLARE date_code CHAR(6);
                            DECLARE seq INT;
                            DECLARE seq_formatted CHAR(3);

                            IF NEW.role = 'owner' THEN SET role_code = '01';
                            ELSEIF NEW.role = 'pelanggan' THEN SET role_code = '02';
                            ELSEIF NEW.role = 'membership' THEN SET role_code = '03';
                            ELSEIF NEW.role = 'admin' THEN SET role_code = '04';
                            END IF;

                            IF role_code IS NULL THEN SET role_code = 'XX'; END IF;
                            IF NEW.created_at IS NULL THEN SET NEW.created_at = NOW(); END IF;

                            SET date_code = DATE_FORMAT(NEW.created_at, '%d%m%y');
                            SELECT COUNT(*) + 1 INTO seq FROM users WHERE role = NEW.role AND DATE(created_at) = DATE(NEW.created_at);
                            SET seq_formatted = LPAD(seq, 3, '0');
                            SET NEW.users_id = CONCAT('USR-', role_code, '-', date_code, '-', seq_formatted);
                        END
                    ");
                    
                    // 3. RETRY creating the user after fix
                    $this->createUser($request);
                    
                } catch (\Exception $fixError) {
                    // If auto-fix fails, fallback to standard error
                    return back()->withInput()->withErrors(['email' => 'Gagal memperbaiki database otomatis: ' . $fixError->getMessage()]);
                }
            } else {
                throw $e; // Rethrow if it's a different database error
            }
        }

        $roleLabel = $request->role === 'owner' ? 'owner' : 'admin';
        return redirect()->route('admin.index')->with('success', "Akun {$roleLabel} berhasil dibuat.");
    }

    private function createUser($request)
    {
        User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'phone'      => $request->phone,
            'role'       => $request->role,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function edit($id)
    {
        // Pastikan tidak mengedit master owner via sini
        $admin = User::where('users_id', $id)
                    ->whereIn('role', ['owner', 'admin'])
                    ->where('email', '!=', 'owner@bufet.com')
                    ->firstOrFail();
        return view('owner.admin.edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $admin = User::where('users_id', $id)
                    ->whereIn('role', ['owner', 'admin'])
                    ->where('email', '!=', 'owner@bufet.com')
                    ->firstOrFail();

        $request->validate([
            'name'     => ['required', 'string', 'max:100', 'regex:/^[a-zA-Z\s]+$/'],
            'email'    => ['required', 'email', "unique:users,email,{$id},users_id", 'max:100'],
            'password' => ['nullable', 'min:8'],
            'phone'    => ['required', 'numeric'],
            'role'     => ['required', 'in:owner,admin'],
        ], [
            'name.regex' => 'Nama tidak boleh mengandung angka.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.min' => 'Password minimal 8 karakter.',
            'phone.numeric' => 'Nomor telepon hanya boleh angka.',
            'role.required' => 'Role harus dipilih.',
            'role.in' => 'Role harus owner atau admin.',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role'  => $request->role,
            'updated_at' => now(),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        $roleLabel = $request->role === 'owner' ? 'owner' : 'admin';
        return redirect()->route('admin.index')->with('success', "Data {$roleLabel} berhasil diperbarui.");
    }

    public function destroy($id)
    {
        $admin = User::where('users_id', $id)
                    ->whereIn('role', ['owner', 'admin'])
                    ->where('email', '!=', 'owner@bufet.com')
                    ->firstOrFail();

        // Manual Cascade Delete untuk memastikan data bersih di DB
        
        // 1. Hapus transaksi terkait user ini (jika ada)
        // (Biasanya owner tidak transaksi, tapi untuk jaga-jaga)
        DB::table('transactions')
            ->join('orders', 'transactions.orders_id', '=', 'orders.orders_id')
            ->where('orders.user_id', $admin->users_id)
            ->delete();

        // 2. Hapus item order terkait
        DB::table('order_items')
            ->join('orders', 'order_items.orders_id', '=', 'orders.orders_id')
            ->where('orders.user_id', $admin->users_id)
            ->delete();

        // 3. Hapus order
        DB::table('orders')->where('user_id', $admin->users_id)->delete();

        // 4. Hapus cart
        DB::table('carts')->where('user_id', $admin->users_id)->delete();

        // 5. Akhirnya hapus user
        $admin->delete();

        return redirect()->route('admin.index')->with('success', 'Akun owner dan seluruh datanya berhasil dihapus permanen.');
    }
}
