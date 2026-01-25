<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\User;

Route::get('/debug-db', function () {
    try {
        $columns = DB::select('DESCRIBE users');
        $roleCol = collect($columns)->firstWhere('Field', 'role');
        
        echo "<h1>Users Table Structure</h1>";
        echo "<pre>" . print_r($columns, true) . "</pre>";
        echo "<h2>Role Column Type</h2>";
        echo "<pre>" . print_r($roleCol, true) . "</pre>";
        
        // Try creating a dummy admin user in a transaction and rolling back
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => 'Debug Admin',
                'email' => 'debug.admin@example.com',
                'password' => bcrypt('password'),
                'phone' => '081234567890',
                'role' => 'admin'
            ]);
            echo "<h2>Creation Test: SUCCESS</h2>";
            echo "User ID generated: " . $user->users_id;
        } catch (\Exception $e) {
            echo "<h2>Creation Test: FAILED</h2>";
            echo "Error: " . $e->getMessage();
        }
        DB::rollBack();
        
    } catch (\Exception $e) {
        echo "Generic Error: " . $e->getMessage();
    }
});
