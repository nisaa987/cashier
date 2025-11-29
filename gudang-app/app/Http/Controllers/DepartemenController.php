<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departemen;
use App\Models\Employees;

class DepartemenController extends Controller
{
    public function showEmployees(Request $request, $id)
    {
        $departemen = Departemen::findOrFail($id);
        $query = $departemen->employees();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama', 'like', "%{$search}%")
                ->orWhere('job_title', 'like', "%{$search}%");
        }

        $employees = $query->get();

        return view('departemen.employees', compact('departemen', 'employees'));
    }

    public function index(Request $request)
    {
        $search = $request->input('search');

        $departemens = Departemen::when($search, function ($query, $search) {
                return $query->where('nama_departemen', 'like', "%$search%");
            })
            ->orderBy('nama_departemen')
            ->get();

        // Hitung manual jumlah karyawan
        foreach ($departemens as $departemen) {
            $departemen->employees_count = Employees::where('departemen', $departemen->nama_departemen)->count();
        }

        return view('departemen.index', compact('departemens', 'search'));
    }

    public function show($id)
    {
        $departemen = Departemen::findOrFail($id);
        $employees = $departemen->employees;

        return view('departemen.show', compact('departemen', 'employees'));
    }
}
