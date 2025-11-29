<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employees;
use App\Models\Departemen;

class EmployeesController extends Controller
{
public function index(Request $request)
{
    $departemen = $request->input('departemen');
    $search = $request->input('search');

    // Ambil semua data departemen untuk dropdown
    $departemens = Departemen::all();

    // Ambil data karyawan (menyimpan nama departemen langsung)
    $employees = Employees::query()
        ->when($departemen, function ($query, $departemen) {
            return $query->where('departemen', $departemen);
        })
        ->when($search, function ($query, $search) {
            return $query->where('nama', 'like', "%$search%");
        })
        ->get();

    return view('employees.index', compact('employees', 'departemens', 'departemen', 'search'));
}


    public function create()
    {
        $departemen = Departemen::all();
        return view('employees.create', compact('departemen'));
    }

// EmployeesController.php
public function store(Request $request)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'telepon' => 'required|string|max:20',
        'email' => 'required|email|unique:employees',
        'departemen' => 'required|string|max:100', // validasi string, bukan id
        'job_title' => 'required|string|max:100',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $data = [
        'nama' => $request->nama,
        'telepon' => $request->telepon,
        'email' => $request->email,
        'departemen' => $request->departemen, // disimpan langsung dari value form
        'job_title' => $request->job_title,
    ];

    if ($request->hasFile('foto')) {
        $data['foto'] = $request->file('foto')->store('foto_karyawan', 'public');
    }

    Employees::create($data);

    return redirect()->route('employees.index')->with('success', 'Karyawan berhasil ditambahkan');
}

    public function edit($id)
    {
        $employees = Employees::findOrFail($id);
        $departemenList = Departemen::all();

        return view('employees.edit', compact('employees', 'departemenList'));
    }

    public function update(Request $request, $id)
    {
        $employees = Employees::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'email' => 'required|email|unique:employees,email,' . $id,
            'departemen' => 'required|string|max:100',
            'job_title' => 'required|string|max:100',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only('nama', 'telepon', 'email', 'departemen', 'job_title');

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto_karyawan', 'public');
        }

        $employees->update($data);

        return redirect()->route('employees.index')->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $employees = Employees::findOrFail($id);

        if ($employees->foto && \Storage::disk('public')->exists($employees->foto)) {
            \Storage::disk('public')->delete($employees->foto);
        }

        $employees->delete();

        return redirect()->route('employees.index')->with('success', 'Karyawan berhasil dihapus.');
    }
}
