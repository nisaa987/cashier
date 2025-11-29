<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect('/dashboard')->with('error', 'Akses ditolak.');
        }

        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');
        $search = $request->input('search');

        // Ambil data barang masuk
        $barangMasuk = BarangMasuk::with('barang')
            ->when($tanggalAwal && $tanggalAkhir, function ($query) use ($tanggalAwal, $tanggalAkhir) {
                return $query->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir]);
            })
            ->when($search, function ($query) use ($search) {
                return $query->whereHas('barang', function ($q) use ($search) {
                    $q->where('nama_barang', 'like', "%{$search}%");
                });
            })
            ->get();

        // Ambil data barang keluar
        $barangKeluar = BarangKeluar::when($tanggalAwal && $tanggalAkhir, function ($query) use ($tanggalAwal, $tanggalAkhir) {
                return $query->whereBetween('tanggal_keluar', [$tanggalAwal, $tanggalAkhir]);
            })
            ->when($search, function ($query) use ($search) {
                return $query->where('nama_barang', 'like', "%{$search}%");
            })
            ->get();

        return view('laporan.index', compact('barangMasuk', 'barangKeluar', 'tanggalAwal', 'tanggalAkhir', 'search'));
    }

    public function laporanBarang(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect('/dashboard')->with('error', 'Akses ditolak.');
        }

        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');
        $search = $request->input('search');

        // Barang Masuk
        $barangMasuk = BarangMasuk::with('barang')
            ->when($tanggalAwal && $tanggalAkhir, function ($query) use ($tanggalAwal, $tanggalAkhir) {
                return $query->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir]);
            })
            ->when($search, function ($query) use ($search) {
                return $query->whereHas('barang', function ($q) use ($search) {
                    $q->where('nama_barang', 'like', "%{$search}%");
                });
            })
            ->get();

        // Barang Keluar
        $barangKeluar = BarangKeluar::when($tanggalAwal && $tanggalAkhir, function ($query) use ($tanggalAwal, $tanggalAkhir) {
                return $query->whereBetween('tanggal_keluar', [$tanggalAwal, $tanggalAkhir]);
            })
            ->when($search, function ($query) use ($search) {
                return $query->where('nama_barang', 'like', "%{$search}%");
            })
            ->get();

        return view('laporan.barang', compact('barangMasuk', 'barangKeluar', 'tanggalAwal', 'tanggalAkhir', 'search'));
    }

public function masuk(Request $request)
{
    $query = BarangMasuk::with('barang');

    if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
        $query->whereBetween('tanggal', [$request->tanggal_awal, $request->tanggal_akhir]);
    }

    if ($request->filled('search')) {
        $query->whereHas('barang', function ($q) use ($request) {
            $q->where('nama_barang', 'like', "%" . $request->search . "%");
        });
    }

    $barangMasuk = $query->paginate(10)->appends($request->all());

    return view('laporan.masuk', compact('barangMasuk'));
}

public function keluar(Request $request)
{
    $query = BarangKeluar::query();

    if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
        $query->whereBetween('tanggal_keluar', [$request->tanggal_awal, $request->tanggal_akhir]);
    }

    if ($request->filled('search')) {
        $query->where('nama_barang', 'like', "%" . $request->search . "%");
    }

    $barangKeluar = $query->paginate(10)->appends($request->all());

    return view('laporan.keluar', compact('barangKeluar'));
}

}
