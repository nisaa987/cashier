<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    
    //
    use HasFactory;

    protected $table = 'pelanggan';
    protected $primaryKey = 'PelangganID';
    protected $fillable = ['namaPelanggan', 'alamat', 'nomor_telepon', 'jenis_pelanggan'];

    public function penjualan(){
        return $this->hasMany(penjualan::class, 'pelangganID', 'PelangganID');
    }

    public function getDiskon()
    {
        return match ($this->jenis_pelanggan) {
            'member' => 0.05, //Diskon 5%
            'vip' => 0.10, //Diskon 10%
            'biasa' => 0.00 //Tidak ada diskon
        };  
         return $this->jenis_pelanggan === 'VIP' ? 0.1 : 0;
    }
}
