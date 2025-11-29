<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Departemen;

class DepartemenSeeder extends Seeder
{
    public function run(): void
    {
        
        $departemen = [
            'admin',
            'petugas',
            'administration',
            'infrastruktur',
            'management',
            'network engineer',
            'research & development',
            'sales',
            'software',
            'support',
        ];

        foreach ($departemen as $nama) {
            Departemen::create(['nama_departemen' => $nama]);
        }
    }
}
