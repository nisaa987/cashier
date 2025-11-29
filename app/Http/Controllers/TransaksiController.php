<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Produk;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class TransaksiController extends Controller
{
    public function index()
{
    $penjualan = Penjualan::latest()->get();
    return view('transaksi.index', compact('penjualan'));
}

    /**
     * Menampilkan form transaksi baru.
     */
    public function create()
    {
        $pelanggan = Pelanggan::all();
        $produk = Produk::all();
        return view('transaksi.create', compact('pelanggan', 'produk'));
    }

    /**
     * Menyimpan transaksi dan redirect ke halaman struk.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pelangganID' => 'required|exists:pelanggan,PelangganID',
            'produkID' => 'required|array',
            'produkID.*' => 'exists:produk,produkID',
            'jumlahProduk' => 'required|array',
            'jumlahProduk.*' => 'integer|min:1',
            'pembayaran' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $pelanggan = Pelanggan::findOrFail($request->pelangganID);
            $diskonRate = $pelanggan->getDiskon();

            // Buat transaksi penjualan
            $penjualan = Penjualan::create([
                'tanggalPenjualan' => now(),
                'totalHarga' => 0, // sementara
                'pelangganID' => $pelanggan->PelangganID,
                'user_id' => auth()->id(),
            ]);

            $totalHargaSebelumDiskon = 0;

            foreach ($request->produkID as $key => $produkID) {
                $produk = Produk::findOrFail($produkID);
                $jumlah = $request->jumlahProduk[$key];
                $subTotal = $produk->harga * $jumlah;

                DetailPenjualan::create([
                    'penjualanID' => $penjualan->PenjualanID,
                    'produkID' => $produkID,
                    'jumlahProduk' => $jumlah,
                    'subTotal' => $subTotal,
                ]);

                $totalHargaSebelumDiskon += $subTotal;

                // Kurangi stok
                $produk->stok -= $jumlah;
                $produk->save();
            }

            $diskon = $totalHargaSebelumDiskon * $diskonRate;
            $totalHargaSetelahDiskon = $totalHargaSebelumDiskon - $diskon;

            $penjualan->update(['totalHarga' => $totalHargaSetelahDiskon]);

            $pembayaran = $request->pembayaran;
            $kembalian = $pembayaran - $totalHargaSetelahDiskon;

            // Simpan ke session untuk digunakan di struk
            session([
                'pembayaran' => $pembayaran,
                'kembalian' => $kembalian,
                'nama_kasir' => $request->nama_kasir

            ]);

            DB::commit();

            return redirect()->route('transaksi.printStruk', ['id' => $penjualan->PenjualanID]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Terjadi kesalahan saat menyimpan transaksi: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan struk transaksi.
     */
 public function printStruk($id)
{
    $penjualan = Penjualan::with(['detailPenjualan.produk', 'pelanggan'])->findOrFail($id);
    $totalHargaSebelumDiskon = $penjualan->detailPenjualan->sum('subTotal');

    // Ambil jenis pelanggan dan tentukan diskon
    $diskonRate = 0;
    if ($penjualan->pelanggan && method_exists($penjualan->pelanggan, 'getDiskon')) {
        $diskonRate = $penjualan->pelanggan->getDiskon();
    }

    $diskon = $totalHargaSebelumDiskon * $diskonRate;
    $totalHarga = $totalHargaSebelumDiskon - $diskon;

    $pembayaran = session('pembayaran', 0);
    $kembalian = session('kembalian', 0);
    $namaKasir = session('nama_kasir', 'Tidak diketahui');

    return view('transaksi.struk', compact(
        'penjualan', 'totalHargaSebelumDiskon',
        'diskonRate', 'diskon', 'totalHarga',
        'pembayaran', 'kembalian', 'namaKasir'
    ));
}


    public function cetakPdf($id)
    {
        $penjualan = Penjualan::with(['detailPenjualan.produk'])->findOrFail($id);

        $totalHargaSebelumDiskon = $penjualan->detailPenjualan->sum('subTotal');
        $diskonRate = 0; // atau sesuai logika kamu
        $diskon = $totalHargaSebelumDiskon * $diskonRate;
        $totalHarga = $totalHargaSebelumDiskon - $diskon;
        $pembayaran = $penjualan->pembayaran ?? 0;
        $kembalian = $pembayaran - $totalHarga;
        $namaKasir = 'Kasir'; // bisa diambil dari auth atau lainnya

        $pdf = PDF::loadView('transaksi.struk', compact(
            'penjualan', 'totalHargaSebelumDiskon', 'diskonRate',
            'diskon', 'totalHarga', 'pembayaran', 'kembalian', 'namaKasir'
        ));

        return $pdf->stream('struk_'.$penjualan->id.'.pdf');
    }



}
