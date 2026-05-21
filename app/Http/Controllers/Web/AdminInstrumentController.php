<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\InstrumentGroup;
use App\Models\InstrumentQuestion;
use App\Models\InstrumentResult;
use Illuminate\Http\Request;

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
        $search = $request->get('search');

        $results = InstrumentResult::with('user')
            ->when($search, function ($q) use ($search) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%"));
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        return view('admin.instruments.results', compact('results', 'search'));
    }

    public function resultDetail($id)
    {
        $result = InstrumentResult::with('user')->findOrFail($id);
        $groups = InstrumentGroup::with('questions')->orderBy('order')->get();

        return view('admin.instruments.result-detail', compact('result', 'groups'));
    }
}
