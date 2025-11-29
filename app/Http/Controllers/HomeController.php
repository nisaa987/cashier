<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DetailPenjualan;
use App\Models\Penjualan;  // import model Penjualan
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index(Request $request)
    {
        // Data best sellers
        $bestSellers = DetailPenjualan::select('produkID', DB::raw('SUM(jumlahProduk) as total_terjual'))
            ->groupBy('produkID')
            ->orderByDesc('total_terjual')
            ->take(5)
            ->get();

        // Hitung pemasukan hari ini, minggu ini, bulan ini menggunakan model Penjualan dan kolom yang benar
        $todayIncome = Penjualan::incomeToday();

        $weekIncome = Penjualan::incomeWeek();

        $monthIncome = Penjualan::incomeMonth();

        // Kirim semua data ke view
        return view('home.home', compact('bestSellers', 'todayIncome', 'weekIncome', 'monthIncome'));
    }
}
