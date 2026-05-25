<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use Illuminate\Http\Request;

class AdminDesaController extends Controller
{
    public function index()
    {
        $desas = Desa::withCount('users')->orderBy('created_at', 'desc')->get();

        return view('admin.desa.index', compact('desas'));
    }

    public function create()
    {
        return view('admin.desa.form', ['desa' => new Desa]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
        ]);

        Desa::create($validated);

        return redirect()->route('admin.desa.index')->with('success', 'Desa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $desa = Desa::findOrFail($id);

        return view('admin.desa.form', compact('desa'));
    }

    public function update(Request $request, $id)
    {
        $desa = Desa::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
        ]);

        $desa->update($validated);

        return redirect()->route('admin.desa.index')->with('success', 'Desa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $desa = Desa::findOrFail($id);

        if ($desa->users()->count() > 0) {
            return redirect()->route('admin.desa.index')->with('error', 'Desa tidak dapat dihapus karena masih memiliki pengguna.');
        }

        $desa->delete();

        return redirect()->route('admin.desa.index')->with('success', 'Desa berhasil dihapus.');
    }
}
