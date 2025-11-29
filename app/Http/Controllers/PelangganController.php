<?php
namespace App\Http\Controllers; 
 
use App\Models\Pelanggan; 
use Illuminate\Http\Request; 
 
class PelangganController extends Controller 
{ 
    /** 
     * Menampilkan daftar pelanggan. 
     */ 
    public function index() 
    { 
        $pelanggan = Pelanggan::all(); 
        return view('pelanggan.index', compact('pelanggan')); 
    } 
 
    /** 
     * Menampilkan form tambah pelanggan. 
     */ 
    public function create() 
    { 
        return view('pelanggan.create'); 
    } 
 
    /** 
     * Menyimpan data pelanggan baru. 
     */ 
    public function store(Request $request) 
    { 
        $request->validate([ 
            'namaPelanggan' => 'required', 
            'alamat' => 'required', 
            'nomor_telepon' => 'required|string',
            'jenis_pelanggan' => 'required|string',
        ]); 
 
        Pelanggan::create([
            'namaPelanggan' => $request->namaPelanggan,
            'alamat' => $request->alamat,
            'nomor_telepon' => $request->nomor_telepon,
            'jenis_pelanggan' => $request->jenis_pelanggan,
        ]);
 
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil ditambahkan.'); 
    }
 
    /** 
     * Menampilkan detail pelanggan. 
     */ 
    public function show($id) 
    { 
        $pelanggan = Pelanggan::findOrFail($id); 
        return view('pelanggan.show', compact('pelanggan')); 
    } 
 
    /** 
     * Menampilkan form edit pelanggan. 
     */ 
    public function edit($id) 
    { 
        $pelanggan = Pelanggan::findOrFail($id); 
        return view('pelanggan.edit', compact('pelanggan')); 
    } 
 
    /** 
     * Menyimpan perubahan data pelanggan. 
     */ 
    public function update(Request $request, $id) 
    { 
        $request->validate([ 
            'namaPelanggan' => 'required', 
            'alamat' => 'required', 
            'nomor_telepon' => 'required|string', 
            'jenis_pelanggan' => 'required|string',
        ]); 
 
        $pelanggan = pelanggan::findOrFail($id); 
        $pelanggan->update($request->all()); 
 
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil diperbarui.'); 
    } 
 
    /** 
     * Menghapus data pelanggan. 
     */ 
public function destroy($PelangganID)
{
    $pelanggan = pelanggan::where('PelangganID', $PelangganID)->firstOrFail();
    $pelanggan->delete();
    return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil dihapus.');
}

}
