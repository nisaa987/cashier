<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Generator;
use Milon\Barcode\DNS1D;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/dashboard')->with('error', 'Akses ditolak.');
        }

        $search = $request->search;
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        $barangs = Barang::query()
            ->when($search, function ($query) use ($search) {
                $query->where('nama_barang', 'like', '%' . $search . '%');
            })
            ->when($tanggalAwal && $tanggalAkhir, function ($query) use ($tanggalAwal, $tanggalAkhir) {
                $query->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir]);
            })
            ->get();

        $qr = new Generator();
        $barcodeGen = new DNS1D();

        foreach ($barangs as $item) {
            // QR Code untuk barang keluar
$url = route('barangkeluar.create', ['barang_id' => $item->id]);
$item->qr_code = $qr->size(150)->format('svg')->generate($url);

            // Barcode — pakai kode_barang jika ada, fallback ke ID
            $kodeBarcode = $item->kode_barang ?? (string) $item->id;
            $item->barcode = $barcodeGen->getBarcodeHTML((string) $kodeBarcode, 'C128', 2, 50, 'black', true);
        }

        return view('barang.index', compact('barangs', 'tanggalAwal', 'tanggalAkhir'));
    }

    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'tanggal_input' => 'required|date',
            'nama_barang' => 'required|string',
            'stok' => 'required|integer|min:1',
            'satuan_barang' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $barang = Barang::where('nama_barang', $request->nama_barang)->first();

        if ($barang) {
            $barang->stok += $request->stok;
            $barang->tanggal = $request->tanggal;
            $barang->tanggal_input = $request->tanggal_input;
            $barang->satuan_barang = $request->satuan_barang;

            if ($request->hasFile('foto')) {
                $path = $request->file('foto')->store('foto_barang', 'public');
                $barang->foto = $path;
            }

            $barang->save();

            if ($request->query('from') === 'barang-masuk') {
                return redirect()->route('barang-masuk.create')
                    ->with('success', 'Stok barang berhasil ditambahkan!');
            }

            return redirect()->route('barang.index')->with('success', 'Stok barang berhasil ditambahkan!');
        } else {
            $barangBaru = new Barang();
            $barangBaru->tanggal = $request->tanggal;
            $barangBaru->nama_barang = $request->nama_barang;
            $barangBaru->stok = $request->stok;
            $barangBaru->satuan_barang = $request->satuan_barang;

            if ($request->hasFile('foto')) {
                $path = $request->file('foto')->store('foto_barang', 'public');
                $barangBaru->foto = $path;
            }

            $barangBaru->save();

            if ($request->query('from') === 'barang-masuk') {
                return redirect()->route('barang-masuk.create')
                    ->with('success', 'Barang baru berhasil ditambahkan!');
            }

            return redirect()->route('barang.index')->with('success', 'Barang baru berhasil ditambahkan!');
        }
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nama_barang' => 'required|string',
            'stok' => 'required|integer|min:1',
            'satuan_barang' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $barang->tanggal = $request->tanggal;
        $barang->nama_barang = $request->nama_barang;
        $barang->stok = $request->stok;
        $barang->satuan_barang = $request->satuan_barang;

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('foto_barang', 'public');
            $barang->foto = $path;
        }

        $barang->save();
        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui!');
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();
        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $barangs = Barang::query();

        if ($query) {
            $barangs = $barangs->orderByRaw("CASE 
                WHEN nama_barang LIKE ? THEN 0
                WHEN nama_barang LIKE ? THEN 1
                WHEN nama_barang LIKE ? THEN 2
                ELSE 3
            END", ["$query", "$query%", "%$query%"]);

            $barangs = $barangs->where(function ($q) use ($query) {
                $q->where('nama_barang', 'like', "%$query%")
                  ->orWhere('kode_barang', 'like', "%$query%");
            });
        }

        return view('barang.index', [
            'barangs' => $barangs->get()
        ]);
    }

    public function show($id)
    {
        $barang = Barang::findOrFail($id);
        return view('barang.show', compact('barang'));
    }

public function print($id)
{
    $barang = Barang::findOrFail($id);
    return view('barang.print', compact('barang'));
}

public function printbc($id)
{
    $barang = Barang::findOrFail($id);
    return view('barang.printbc', compact('barang'));
}

}
