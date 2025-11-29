<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Departemen;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
            $this->call(DepartemenSeeder::class);
                $this->call(UserSeeder::class);


    User::create([
        'name' => 'admin',
        'email' => 'admin@gudang.com',
        'password' => Hash::make('admin123'),
        'role' => 'admin'
    ]); 

    User::create([
        'name' => 'petugas',
        'email' => 'petugas@gmail.com',
        'password' => Hash::make('petugas'),
        'role' => 'petugas'
    ]);


    }
} 
