<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek jika owner sudah ada untuk menghindari duplikasi saat seed dijalankan ulang
        $exist = DB::table('users')->where('email', 'owner@bufet.com')->exists();

        if (!$exist) {
            DB::table('users')->insert([
                // users_id akan di-handle oleh Trigger MySQL
                'name'       => 'Owner Bufet',
                'email'      => 'owner@bufet.com',
                'password'   => Hash::make('password'),
                'phone'      => '081234567890',
                'role'       => 'owner',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->command->info('Owner account created! Email: owner@bufet.com | Password: password');
        } else {
            $this->command->warn('Owner account already exists.');
        }
    }
}
