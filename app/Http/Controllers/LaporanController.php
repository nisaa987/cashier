<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Pelanggan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Ambil tanggal dari request, atau pakai default awal & akhir bulan
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        // Ambil data penjualan berdasarkan rentang tanggal
        $penjualan = Penjualan::whereBetween('tanggalPenjualan', [$startDate, $endDate])
            ->with(['pelanggan', 'detailPenjualan.produk'])
            ->orderBy('tanggalPenjualan', 'desc')
            ->get();

        // Ambil data menu terlaris
        $menuTerlaris = DB::table('detail_penjualan')
            ->select('produk.produkID', 'produk.namaProduk', DB::raw('SUM(detail_penjualan.jumlahProduk) as total_terjual'))
            ->join('produk', 'detail_penjualan.produkID', '=', 'produk.produkID')
            ->groupBy('produk.produkID', 'produk.namaProduk')
            ->orderByDesc('total_terjual')
            ->limit(10)
            ->get();

        // Kirim semua data ke view
        return view('laporan.index', compact('penjualan', 'startDate', 'endDate', 'menuTerlaris'));
    }

    public function destroy($id)
    {
        $laporan = Penjualan::find($id);
        if ($laporan) {
            $laporan->delete();
            return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dihapus.');
        }
        return redirect()->route('laporan.index')->with('error', 'Laporan tidak ditemukan.');
    }

    public function tampilMenuTerlaris()
    {
        $menuTerlaris = DB::table('detail_penjualan')
            ->select('produkID', DB::raw('SUM(jumlahProduk) as total_terjual'))
            ->groupBy('produkID')
            ->orderByDesc('total_terjual')
            ->limit(10)
            ->get();

        return view('laporan.index', compact('menuTerlaris'));
    }

    public function apiMenuTerlaris()
    {
        $menuTerlaris = DetailPenjualan::select('produkID', DB::raw('SUM(jumlahProduk) as total_terjual'))
            ->groupBy('produkID')
            ->orderByDesc('total_terjual')
            ->with('produk')
            ->take(10)
            ->get();

        return response()->json($menuTerlaris);
    }

    public function redirectToHomeTerlaris()
    {
        session()->flash('show_terlaris', true);
        return redirect()->route('home');
    }
}
