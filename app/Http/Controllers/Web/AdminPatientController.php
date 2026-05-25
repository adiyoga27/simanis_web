<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminPatientController extends Controller
{
    public function index(Request $request)
    {
        $currentUser = Auth::user();

        $query = User::where('role', 'pasien');

        if (in_array($currentUser->role, ['kader', 'kepala_desa']) && $currentUser->desa_id) {
            $query->where('desa_id', $currentUser->desa_id);
        }

        $search = $request->get('search');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%");
            });
        }

        $desaId = $request->get('desa_id');
        if ($desaId && in_array($currentUser->role, ['superadmin', 'kepala_puskesmas'])) {
            $query->where('desa_id', $desaId);
        }

        $patients = $query->with('desa')->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        $desas = Desa::orderBy('name')->get();

        return view('admin.patients.index', compact('patients', 'search', 'desas', 'desaId'));
    }

    public function create()
    {
        $currentUser = Auth::user();
        $desas = Desa::orderBy('name')->get();

        $autoDesaId = null;
        $showDesaField = in_array($currentUser->role, ['superadmin', 'kepala_puskesmas']);

        if (in_array($currentUser->role, ['kader', 'kepala_desa']) && $currentUser->desa_id) {
            $autoDesaId = $currentUser->desa_id;
        }

        return view('admin.patients.form', [
            'patient' => new User,
            'desas' => $desas,
            'autoDesaId' => $autoDesaId,
            'showDesaField' => $showDesaField,
        ]);
    }

    public function store(Request $request)
    {
        $currentUser = Auth::user();

        $rules = [
            'name' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'jk' => 'required|in:L,P',
            'phone' => 'nullable|string|max:20',
            'address' => 'required|string',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'subdistrict' => 'required|string|max:100',
            'village' => 'required|string|max:100',
            'kode_pos' => 'required|string|max:10',
            'blood' => 'required|in:O,A,B,AB',
            'tall' => 'required|integer|min:1|max:300',
            'weight' => 'required|integer|min:1|max:500',
            'is_smoke' => 'required|in:0,1',
            'medical_history' => 'nullable|string',
        ];

        if (in_array($currentUser->role, ['superadmin', 'kepala_puskesmas'])) {
            $rules['desa_id'] = 'required|exists:desas,id';
        }

        $validated = $request->validate($rules);

        if (in_array($currentUser->role, ['kader', 'kepala_desa'])) {
            $validated['desa_id'] = $currentUser->desa_id;
        }

        $nameSlug = Str::slug($validated['name'], '');
        $baseUsername = Str::lower($nameSlug);
        $username = $baseUsername;
        $counter = 1;
        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        $email = $username . '@pasien.simanis.id';
        while (User::where('email', $email)->exists()) {
            $email = $username . $counter . '@pasien.simanis.id';
            $counter++;
        }

        $validated['username'] = $username;
        $validated['email'] = $email;
        $validated['password'] = Hash::make(Str::random(10));
        $validated['role'] = 'pasien';
        $validated['email_verified_at'] = now();

        User::create($validated);

        return redirect()->route('admin.patients.index')->with('success', 'Pasien berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $currentUser = Auth::user();
        $patient = User::where('role', 'pasien')->findOrFail($id);

        if (in_array($currentUser->role, ['kader', 'kepala_desa']) && $patient->desa_id !== $currentUser->desa_id) {
            return redirect()->route('admin.patients.index')->with('error', 'Anda tidak dapat mengedit pasien dari desa lain.');
        }

        $desas = Desa::orderBy('name')->get();

        $autoDesaId = null;
        $showDesaField = in_array($currentUser->role, ['superadmin', 'kepala_puskesmas']);

        if (in_array($currentUser->role, ['kader', 'kepala_desa']) && $currentUser->desa_id) {
            $autoDesaId = $currentUser->desa_id;
        }

        return view('admin.patients.form', compact('patient', 'desas', 'autoDesaId', 'showDesaField'));
    }

    public function update(Request $request, $id)
    {
        $currentUser = Auth::user();
        $patient = User::where('role', 'pasien')->findOrFail($id);

        if (in_array($currentUser->role, ['kader', 'kepala_desa']) && $patient->desa_id !== $currentUser->desa_id) {
            return redirect()->route('admin.patients.index')->with('error', 'Anda tidak dapat mengedit pasien dari desa lain.');
        }

        $rules = [
            'name' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'jk' => 'required|in:L,P',
            'phone' => 'nullable|string|max:20',
            'address' => 'required|string',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'subdistrict' => 'required|string|max:100',
            'village' => 'required|string|max:100',
            'kode_pos' => 'required|string|max:10',
            'blood' => 'required|in:O,A,B,AB',
            'tall' => 'required|integer|min:1|max:300',
            'weight' => 'required|integer|min:1|max:500',
            'is_smoke' => 'required|in:0,1',
            'medical_history' => 'nullable|string',
        ];

        if (in_array($currentUser->role, ['superadmin', 'kepala_puskesmas'])) {
            $rules['desa_id'] = 'required|exists:desas,id';
        }

        $validated = $request->validate($rules);

        if (in_array($currentUser->role, ['kader', 'kepala_desa'])) {
            $validated['desa_id'] = $currentUser->desa_id;
        }

        $patient->update($validated);

        return redirect()->route('admin.patients.index')->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $currentUser = Auth::user();
        $patient = User::where('role', 'pasien')->findOrFail($id);

        if (in_array($currentUser->role, ['kader', 'kepala_desa']) && $patient->desa_id !== $currentUser->desa_id) {
            return redirect()->route('admin.patients.index')->with('error', 'Anda tidak dapat menghapus pasien dari desa lain.');
        }

        $patient->delete();

        return redirect()->route('admin.patients.index')->with('success', 'Pasien berhasil dihapus.');
    }
}
