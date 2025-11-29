<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';
    protected $primaryKey = 'PenjualanID';
    protected $fillable = ['tanggalPenjualan', 'totalHarga', 'pelangganID'];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelangganID', 'PelangganID');
    }

    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'penjualanID', 'PenjualanID');
    }

    // Fungsi hitung pemasukan hari ini
    public static function incomeToday()
    {
        return self::whereDate('tanggalPenjualan', Carbon::today())
            ->sum('totalHarga');
    }

    // Fungsi hitung pemasukan minggu ini
    public static function incomeWeek()
    {
        return self::whereBetween('tanggalPenjualan', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->sum('totalHarga');
    }

    // Fungsi hitung pemasukan bulan ini
    public static function incomeMonth()
    {
        return self::whereBetween('tanggalPenjualan', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->sum('totalHarga');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
