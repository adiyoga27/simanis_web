<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\InstrumentGroup;
use App\Models\InstrumentQuestion;
use App\Models\Desa;
use App\Models\InstrumentResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminInstrumentController extends Controller
{
    // ─── GROUPS ───────────────────────────────────────────────────────

    public function index()
    {
        $groups = InstrumentGroup::with('questions')->orderBy('order')->get();

        return view('admin.instruments.index', compact('groups'));
    }

    public function storeGroup(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'order'       => 'nullable|integer|min:0',
        ]);
        $validated['order'] = $validated['order'] ?? 0;

        InstrumentGroup::create($validated);

        return redirect()->route('admin.instruments.index')
            ->with('success', 'Grup berhasil ditambahkan.');
    }

    public function updateGroup(Request $request, $id)
    {
        $group = InstrumentGroup::findOrFail($id);
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'order'       => 'nullable|integer|min:0',
        ]);
        $validated['order'] = $validated['order'] ?? 0;

        $group->update($validated);

        return redirect()->route('admin.instruments.index')
            ->with('success', 'Grup berhasil diperbarui.');
    }

    public function destroyGroup($id)
    {
        $group = InstrumentGroup::findOrFail($id);
        $group->questions()->delete();
        $group->delete();

        return redirect()->route('admin.instruments.index')
            ->with('success', 'Grup berhasil dihapus.');
    }

    // ─── QUESTIONS ────────────────────────────────────────────────────

    public function createQuestion($groupId)
    {
        $group = InstrumentGroup::findOrFail($groupId);

        return view('admin.instruments.questions.form', [
            'group'    => $group,
            'question' => new InstrumentQuestion,
        ]);
    }

    public function storeQuestion(Request $request, $groupId)
    {
        $group = InstrumentGroup::findOrFail($groupId);

        $validated = $request->validate([
            'question' => 'required|string',
            'order'    => 'nullable|integer|min:0',
        ]);
        $validated['instrument_group_id'] = $group->id;
        $validated['order'] = $validated['order'] ?? 0;

        InstrumentQuestion::create($validated);

        return redirect()->route('admin.instruments.index')
            ->with('success', 'Pertanyaan berhasil ditambahkan.');
    }

    public function editQuestion($id)
    {
        $question = InstrumentQuestion::with('group')->findOrFail($id);

        return view('admin.instruments.questions.form', [
            'group'    => $question->group,
            'question' => $question,
        ]);
    }

    public function updateQuestion(Request $request, $id)
    {
        $question = InstrumentQuestion::findOrFail($id);

        $validated = $request->validate([
            'question' => 'required|string',
            'order'    => 'nullable|integer|min:0',
        ]);
        $validated['order'] = $validated['order'] ?? 0;

        $question->update($validated);

        return redirect()->route('admin.instruments.index')
            ->with('success', 'Pertanyaan berhasil diperbarui.');
    }

    public function destroyQuestion($id)
    {
        InstrumentQuestion::findOrFail($id)->delete();

        return redirect()->route('admin.instruments.index')
            ->with('success', 'Pertanyaan berhasil dihapus.');
    }

    // ─── RESULTS ──────────────────────────────────────────────────────

    public function results(Request $request)
    {
        $currentUser = Auth::user();
        $search = $request->get('search');
        $desaId = $request->get('desa_id');

        $results = InstrumentResult::with('user')
            ->when(in_array($currentUser->role, ['kader', 'kepala_desa']) && $currentUser->desa_id, function ($q) use ($currentUser) {
                $q->whereHas('user', fn($u) => $u->where('desa_id', $currentUser->desa_id));
            })
            ->when($desaId && in_array($currentUser->role, ['superadmin', 'kepala_puskesmas']), function ($q) use ($desaId) {
                $q->whereHas('user', fn($u) => $u->where('desa_id', $desaId));
            })
            ->when($search, function ($q) use ($search) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%"));
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        $desas = Desa::orderBy('name')->get();

        return view('admin.instruments.results', compact('results', 'search', 'desas', 'desaId'));
    }

    public function resultDetail($id)
    {
        $result = InstrumentResult::with('user')->findOrFail($id);
        $groups = InstrumentGroup::with('questions')->orderBy('order')->get();

        return view('admin.instruments.result-detail', compact('result', 'groups'));
    }

    public function destroyResult($id)
    {
        if (Auth::user()->role === 'kepala_puskesmas') {
            abort(403, 'Anda tidak memiliki izin untuk menghapus data.');
        }
        InstrumentResult::findOrFail($id)->delete();
        return back()->with('success', 'Data berhasil dihapus.');
    }
}
