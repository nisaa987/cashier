<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Menampilkan daftar produk.
     */
    public function index()
    {
        $produk = Produk::all();
        return view('produk.index', compact('produk'));
    }

    /**
     * Menampilkan form tambah produk.
     */
    public function create()
    {
        return view('produk.create');
    }

    /**
     * Menyimpan data produk baru atau menambah stok jika nama sama.
     */
    public function store(Request $request)
    {
        $request->validate([
            'namaProduk' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
        ]);

        // Cek apakah produk dengan nama yang sama sudah ada
        $produk = Produk::where('namaProduk', $request->namaProduk)->first();

        if ($produk) {
            // Jika sudah ada, tambahkan stok
            $produk->stok += $request->stok;
            $produk->harga = $request->harga; // Optional: update harga jika diperlukan
            $produk->save();
        } else {
            // Jika belum ada, buat produk baru
            Produk::create($request->all());
        }

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan atau diperbarui.');
    }

    /**
     * Menampilkan detail produk.
     */
    public function show($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produk.show', compact('produk'));
    }

    /**
     * Menampilkan form edit produk.
     */
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produk.edit', compact('produk'));
    }

    /**
     * Menyimpan perubahan data produk.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'namaProduk' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
        ]);

        $produk = Produk::findOrFail($id);
        $produk->update($request->all());

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Menghapus data produk.
     */
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}
