<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat Akun Admin Utama
        User::create([
            'name'     => 'Super Admin Valdo',
            'email'    => 'admin@gmail.com',
            'role'     => 'admin', // Sesuai enum di migration kamu
            'password' => Hash::make('password123'), // Gunakan Hash untuk keamanan
        ]);

        // Membuat Akun Manajemen
        User::create([
            'name'     => 'Manajemen Operasional',
            'email'    => 'manajemen@gmail.com',
            'role'     => 'manajemen',
            'password' => Hash::make('password123'),
        ]);

        // Opsional: Jika kamu ingin membuat 5 user tambahan secara acak untuk testing
        // User::factory(5)->create(['role' => 'manajemen']);
    }
}
