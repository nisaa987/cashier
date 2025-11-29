<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangKeluar;
use App\Models\Barang;
use App\Models\BarangMasuk;
use Carbon\Carbon;

class BarangKeluarController extends Controller
{
public function dashboard()
{
    // Label bulan Jan–Dec
    $bulan = collect(range(1, 12))->map(function ($m) {
        return Carbon::create()->month($m)->format('F');
    });

    // Ambil jumlah barang masuk dan keluar per bulan
    $barangMasuk  = [];
    $barangKeluar = [];

    foreach (range(1, 12) as $m) {
        $barangMasuk[]  = BarangMasuk::whereMonth('tanggal', $m)->count();
        $barangKeluar[] = BarangKeluar::whereMonth('tanggal_keluar', $m)->count();
    }

    // === Top 5 Barang Keluar ===
    $topBarangKeluar = BarangKeluar::select('nama_barang', \DB::raw('SUM(jumlah_keluar) as total_keluar'))
        ->groupBy('nama_barang')
        ->orderByDesc('total_keluar')
        ->limit(5)
        ->get();

    return view('dashboard', compact(
        'bulan',
        'barangMasuk',
        'barangKeluar',
        'topBarangKeluar'
    ));
}


    public function index(Request $request)
    {
        $search = $request->input('search');
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        $barangKeluar = \App\Models\BarangKeluar::query();

        // Filter by search
        if ($search) {
            $barangKeluar->where('nama_barang', 'like', "%{$search}%");
        }
        if ($tanggal_awal && $tanggal_akhir) {
            $barangKeluar->whereBetween('tanggal_keluar', [
                \Carbon\Carbon::parse($tanggal_awal)->startOfDay(),
                \Carbon\Carbon::parse($tanggal_akhir)->endOfDay()
            ]);
        }

        $barangKeluar = BarangKeluar::when($request->search, function($q) use ($request) {
        $q->where('nama_barang', 'like', "%{$request->search}%");
    })
    ->when($request->tanggal_awal, function($q) use ($request) {
        $q->whereDate('tanggal_keluar', '>=', $request->tanggal_awal);
    })
    ->when($request->tanggal_akhir, function($q) use ($request) {
        $q->whereDate('tanggal_keluar', '<=', $request->tanggal_akhir);
    })
    ->orderBy('tanggal_keluar','desc')
    ->paginate(10)
    ->withQueryString();
    

        return view('barang_keluar.index', compact('barangKeluar', 'search', 'tanggal_awal', 'tanggal_akhir'));
    }

    public function create(Request $request)
{
    $barang = null;

    if ($request->has('barang_id')) {
        $barang = \App\Models\Barang::find($request->barang_id);
    }

    return view('barang_keluar.create', compact('barang'));
}

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang'   => 'required|string',
            'jumlah_keluar' => 'required|integer|min:1',
            'tanggal_keluar'=> 'required|date',
            'tanggal_input' => 'required|date',
            'keterangan'    => 'nullable|string',
        ]);

        $barang = Barang::where('nama_barang', $request->nama_barang)->first();

        if (!$barang) {
            return back()->with('error', 'Barang tidak ditemukan.');
        }

        if ($request->jumlah_keluar > $barang->stok) {
            return back()->with('error', 'Jumlah melebihi stok tersedia.');
        }

        $barang->stok -= $request->jumlah_keluar;
        $barang->save();

        BarangKeluar::create($request->only([
            'nama_barang', 'jumlah_keluar', 'tanggal_keluar', 'tanggal_input', 'keterangan'
        ]));

        return redirect()->route('barangkeluar.index')->with('success', 'Barang keluar berhasil disimpan.');
    }

    public function destroy($id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);
        $barangKeluar->delete();

        return redirect()->route('barangkeluar.index')->with('success', 'Barang keluar berhasil dihapus.');
    }

    public function cetakStruk($id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);
        return view('barang_keluar.struk', compact('barangKeluar'));
    }

public function search(Request $request)
{
    $query = $request->input('query');

    $barangKeluar = BarangKeluar::query();

    if ($query) {
        $barangKeluar->where(function ($q) use ($query) {
            $q->where('nama_barang', 'like', "%$query%");
            
            // Pastikan tabel memang punya kolom kode_barang
            if (\Schema::hasColumn('barang_keluar', 'kode_barang')) {
                $q->orWhere('kode_barang', 'like', "%$query%");
            }
        })
        ->orderByRaw("CASE 
            WHEN nama_barang LIKE ? THEN 0
            WHEN nama_barang LIKE ? THEN 1
            WHEN nama_barang LIKE ? THEN 2
            ELSE 3
        END", ["$query", "$query%", "%$query%"]);
    }

    return view('barang_keluar.index', [
        'barangKeluar' => $barangKeluar->latest()->get()
    ]);
}

    public function chartBarangKeluar()
{
    // Ambil top 5 barang yang paling sering keluar
    $barangKeluar = \DB::table('barang_keluar')
        ->select('nama_barang', \DB::raw('SUM(jumlah_keluar) as total_keluar'))
        ->groupBy('nama_barang')
        ->orderByDesc('total_keluar')
        ->limit(5)
        ->get();

    // Siapkan data untuk chart
    $labels = $barangKeluar->pluck('nama_barang');
    $data = $barangKeluar->pluck('total_keluar');

    return view('barang_keluar.chart', compact('labels', 'data'));
}

}
