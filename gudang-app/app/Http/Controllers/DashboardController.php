<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // =====================
            // 1. DATA BULANAN (Jan–Des)
            // =====================
            $bulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

            $barangMasukRaw = BarangMasuk::selectRaw('MONTH(tanggal_masuk) as bulan, SUM(jumlah_masuk) as total')
                ->groupBy('bulan')
                ->pluck('total','bulan')
                ->toArray();

            $barangKeluarRaw = BarangKeluar::selectRaw('MONTH(tanggal_keluar) as bulan, SUM(jumlah_keluar) as total')
                ->groupBy('bulan')
                ->pluck('total','bulan')
                ->toArray();

            // isi array 12 bulan
            $barangMasuk  = array_fill(0, 12, 0);
            $barangKeluar = array_fill(0, 12, 0);

            foreach ($barangMasukRaw as $bln => $total) {
                $barangMasuk[$bln-1] = $total;
            }
            foreach ($barangKeluarRaw as $bln => $total) {
                $barangKeluar[$bln-1] = $total;
            }

            $topBarangKeluar = BarangKeluar::select('nama_barang', DB::raw('SUM(jumlah_keluar) as total_keluar'))
                ->groupBy('nama_barang')
                ->orderByDesc('total_keluar')
                ->limit(3)
                ->get();

        } catch (\Throwable $e) {
            \Log::error('Dashboard error: '.$e->getMessage());

            $bulan        = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
            $barangMasuk  = array_fill(0, 12, 0);
            $barangKeluar = array_fill(0, 12, 0);
            $topBarangKeluar = collect();
        }

        return view('dashboard', compact(
            'bulan','barangMasuk','barangKeluar','topBarangKeluar'
        ));
    }
}
