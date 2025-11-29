<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barangs'; // nama tabel di database

    protected $fillable = [
        'tanggal',
        'nama_barang',
        'jumlah_barang_masuk',
        'stok',
        'satuan_barang',
    ];
    public function barangMasuk()
{
    return $this->hasMany(BarangMasuk::class);
}

}
