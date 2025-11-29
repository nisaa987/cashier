<?php

namespace Database\Seeders;

//mengimpor class bawaan laravel yang berhubungan dengan seeding
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

//mengimpor model user agar dapat digunakan untuk insert data ke table users
use App\Models\User;

//mengimpor facade hash untuk mengenskripsi password 
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * fungsi ini dijalankan saat perintah db:seed dipanggil.
     */
    public function run(): void
    {
        // (komentar opsional) ini digunakan untuk membuat 10 data user dummy dengan factory
        // User::factory()->count(10)->create();

        User::firstOrCreate([
            'name' => 'Test User',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
            'role' => 'admin',
        ]);

        //membuat user kedua dengan role 'kasir'
        User::firstOrCreate([
            'name' => 'Kasir User',
            'email' => 'kasir@kasir.com',
            'password' => Hash::make('password'),
            'role' => 'kasir',
        ]);

        User::create([
            'name' => 'Kasir Default',
            'email' => 'createkasir@example.com',
            'password' => Hash::make('password123'),
            'role' => 'createkasir',
        ]);

        // User::firstOrCreate([
        //     'name' => 'Kasir User 2',
        //     'email' => 'kasir123@kasir123.com',
        //     'password' => Hash::make('password'),
        //     'role' => 'kasir',
        // ]);
    }

    
}
