<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    protected $table = 'barang_keluar';

    protected $fillable = [
        'nama_barang', 'jumlah_keluar', 'tanggal_keluar', 'tanggal_input', 'keterangan'
    ];
}