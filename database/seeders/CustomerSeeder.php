<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = 'pelanggan@bufet.com';
        
        // Cek jika user sudah ada
        $exist = DB::table('users')->where('email', $email)->exists();

        if (!$exist) {
            DB::table('users')->insert([
                // users_id handled by Trigger
                'name'       => 'Pelanggan Setia',
                'email'      => $email,
                'password'   => Hash::make('password'),
                'phone'      => '081298765432',
                'role'       => 'pelanggan',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->command->info('Customer account created! Email: ' . $email . ' | Password: password');
        } else {
            $this->command->warn('Customer account already exists.');
        }
    }
}
