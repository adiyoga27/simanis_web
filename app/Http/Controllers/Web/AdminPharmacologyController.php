<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\PharmacologyRecord;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminPharmacologyController extends Controller
{
    public function index(Request $request)
    {
        $currentUser = Auth::user();
        $search = $request->get('search');
        $desaId = $request->get('desa_id');

        $results = PharmacologyRecord::with(['user', 'creator'])
            ->when(in_array($currentUser->role, ['kader', 'kepala_desa']) && $currentUser->desa_id, function ($q) use ($currentUser) {
                $q->whereHas('user', fn($u) => $u->where('desa_id', $currentUser->desa_id));
            })
            ->when($desaId && in_array($currentUser->role, ['superadmin', 'kepala_puskesmas']), function ($q) use ($desaId) {
                $q->whereHas('user', fn($u) => $u->where('desa_id', $desaId));
            })
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sq) use ($search) {
                    $sq->where('medication_title', 'like', "%{$search}%")
                       ->orWhere('description', 'like', "%{$search}%")
                       ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"));
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        $desas = Desa::orderBy('name')->get();

        return view('admin.pharmacology.index', compact('results', 'search', 'desas', 'desaId'));
    }

    public function create(Request $request)
    {
        $patientId = $request->get('patient_id');
        $patient = $patientId ? User::find($patientId) : null;
        $patients = User::where('role', 'patient')->orderBy('name')->get();

        return view('admin.pharmacology.form', compact('patient', 'patients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'           => 'required|exists:users,id',
            'medication_title'  => 'required|string|max:255',
            'description'       => 'nullable|string',
            'daily_dose'        => 'required|string|max:100',
            'start_date'        => 'required|date',
            'start_time'        => 'nullable|date_format:H:i',
        ]);

        $validated['created_by'] = Auth::id();

        PharmacologyRecord::create($validated);

        return redirect()->route('admin.pharmacology.index')->with('success', 'Data farmakologi berhasil disimpan.');
    }

    public function edit($id)
    {
        $record = PharmacologyRecord::with('user')->findOrFail($id);
        $patients = User::where('role', 'patient')->orderBy('name')->get();

        return view('admin.pharmacology.form', compact('record', 'patients'));
    }

    public function update(Request $request, $id)
    {
        $record = PharmacologyRecord::findOrFail($id);

        $validated = $request->validate([
            'user_id'           => 'required|exists:users,id',
            'medication_title'  => 'required|string|max:255',
            'description'       => 'nullable|string',
            'daily_dose'        => 'required|string|max:100',
            'start_date'        => 'required|date',
            'start_time'        => 'nullable|date_format:H:i',
        ]);

        $record->update($validated);

        return redirect()->route('admin.pharmacology.index')->with('success', 'Data farmakologi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        if (Auth::user()->role === 'kepala_puskesmas') {
            abort(403, 'Anda tidak memiliki izin untuk menghapus data.');
        }

        PharmacologyRecord::findOrFail($id)->delete();

        return back()->with('success', 'Data berhasil dihapus.');
    }

    public function export(Request $request)
    {
        $currentUser = Auth::user();
        $search = $request->get('search');
        $desaId = $request->get('desa_id');

        $query = PharmacologyRecord::with(['user', 'creator'])
            ->when(in_array($currentUser->role, ['kader', 'kepala_desa']) && $currentUser->desa_id, function ($q) use ($currentUser) {
                $q->whereHas('user', fn($u) => $u->where('desa_id', $currentUser->desa_id));
            })
            ->when($desaId && in_array($currentUser->role, ['superadmin', 'kepala_puskesmas']), function ($q) use ($desaId) {
                $q->whereHas('user', fn($u) => $u->where('desa_id', $desaId));
            })
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sq) use ($search) {
                    $sq->where('medication_title', 'like', "%{$search}%")
                       ->orWhere('description', 'like', "%{$search}%")
                       ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"));
                });
            })
            ->orderBy('created_at', 'desc');

        $records = $query->get();

        $filename = 'farmakologi-' . now()->format('Y-m-d-His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($records) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, "\xEF\xBB\xBF");

            fputcsv($handle, ['No', 'Pasien', 'Judul Obat', 'Deskripsi', 'Dosis Perhari', 'Tanggal Mulai', 'Waktu Mulai', 'Dibuat Oleh', 'Waktu Dibuat']);

            foreach ($records as $i => $r) {
                fputcsv($handle, [
                    $i + 1,
                    $r->user?->name ?? '-',
                    $r->medication_title,
                    $r->description ?? '-',
                    $r->daily_dose,
                    $r->start_date?->format('d/m/Y') ?? '-',
                    $r->start_time?->format('H:i') ?? '-',
                    $r->creator?->name ?? '-',
                    $r->created_at->format('d/m/Y H:i:s'),
                ]);
            }

            fclose($handle);
        };

        return new StreamedResponse($callback, 200, $headers);
    }
}
