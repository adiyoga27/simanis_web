<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Medication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicationController extends Controller
{
    public function index()
    {
        $medications = Medication::where('user_id', Auth::id())
            ->orderBy('date_at', 'desc')
            ->orderBy('time_at', 'asc')
            ->get();

        return view('medications.index', compact('medications'));
    }

    public function create()
    {
        return view('medications.form', ['medication' => new Medication]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'dosis' => 'nullable|string|max:255',
            'date_at' => 'required|date',
            'time_at' => 'required',
            'duration' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $validated['user_id'] = Auth::id();

        Medication::create($validated);

        return redirect()->route('medications.index')->with('success', 'Jadwal obat berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $medication = Medication::where('user_id', Auth::id())->findOrFail($id);

        return view('medications.form', compact('medication'));
    }

    public function update(Request $request, $id)
    {
        $medication = Medication::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'dosis' => 'nullable|string|max:255',
            'date_at' => 'required|date',
            'time_at' => 'required',
            'duration' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $medication->update($validated);

        return redirect()->route('medications.index')->with('success', 'Jadwal obat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $medication = Medication::where('user_id', Auth::id())->findOrFail($id);
        $medication->delete();

        return redirect()->route('medications.index')->with('success', 'Jadwal obat berhasil dihapus.');
    }
}
