<?php

namespace Database\Seeders;

//mengimpor class bawaan laravel yang berhubungan dengan seeding
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

//mengimpor model user agar dapat digunakan untuk insert data ke table users
use App\Models\User;

//mengimpor facade hash untuk mengenskripsi password 
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder

{
    /**
     * fungsi ini dijalankan saat perintah db:seed dipanggil.
     */
    public function run(): void
    {
        // (komentar opsional) ini digunakan untuk membuat 10 data user dummy dengan factory
        // User::factory()->count(10)->create();

        User::create([
            'name' => 'Test User',
            'email' => 'adminuser@example.com',
            'password' => Hash::make('admin'),
            'role' => 'adminuser',
        ]);

        //membuat user kedua dengan role 'kasir'
        User::create([
            'name' => 'Kasir User',
            'email' => 'kasiruser@example.com',
            'password' => Hash::make('password'),
            'role' => 'kasiruser',
        ]);

        // $this->call(KasirSeeder::class);
    }
}
