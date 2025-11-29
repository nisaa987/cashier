<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\BarangMasuk;
use SimpleSoftwareIO\QrCode\Generator;
use Carbon\Carbon;

class BarangMasukController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        $data = BarangMasuk::with('barang')
            ->when($search, function ($query, $search) {
                $query->whereHas('barang', function ($q) use ($search) {
                    $q->where('nama_barang', 'like', '%' . $search . '%');
                });
            })
            ->when($tanggal_awal && $tanggal_akhir, function ($query) use ($tanggal_awal, $tanggal_akhir) {
                $query->whereBetween('tanggal', [
                    Carbon::parse($tanggal_awal)->startOfDay(),
                    Carbon::parse($tanggal_akhir)->endOfDay()
                ]);
            })
            ->latest()
            ->paginate(10) 
            ->withQueryString(); 

        return view('barang_masuk.index', compact('data', 'search', 'tanggal_awal', 'tanggal_akhir'));
    }

    public function create()
    {
        $barang = Barang::all();
        return view('barang_masuk.create', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'tanggal_input' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        BarangMasuk::create([
            'barang_id' => $request->barang_id,
            'jumlah' => $request->jumlah,
            'tanggal' => $request->tanggal,
            'tanggal_input' => $request->tanggal_input,
            'keterangan' => $request->keterangan,
        ]);

        $barang = Barang::find($request->barang_id);
        $barang->stok += $request->jumlah;
        $barang->save();

        return redirect()->route('barang-masuk.index')->with('success', 'Barang masuk berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);
        $barangMasuk->delete();

        return redirect()->route('barang-masuk.index')->with('success', 'Barang masuk berhasil dihapus.');
    }
}
