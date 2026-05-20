<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AssessmentGroup;
use App\Models\AssessmentOption;
use App\Models\AssessmentRule;
use App\Models\AssessmentSubGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AssessmentAdminController extends Controller
{
    // ─── GROUPS ────────────────────────────────────────────────────────

    public function index()
    {
        $groups = AssessmentGroup::orderBy('order')->withCount('subGroups')->get();

        return view('admin.assessments.groups.index', compact('groups'));
    }

    public function create()
    {
        return view('admin.assessments.groups.form', ['group' => new AssessmentGroup]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:assessment_groups,slug',
            'description' => 'nullable|string',
            'icon'        => 'nullable|string|max:255',
            'order'       => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['title']);
        $validated['order'] = $validated['order'] ?? 0;

        AssessmentGroup::create($validated);

        return redirect()->route('admin.assessments.index')->with('success', 'Kelompok penilaian berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $group = AssessmentGroup::findOrFail($id);

        return view('admin.assessments.groups.form', compact('group'));
    }

    public function update(Request $request, $id)
    {
        $group = AssessmentGroup::findOrFail($id);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:assessment_groups,slug,' . $group->id,
            'description' => 'nullable|string',
            'icon'        => 'nullable|string|max:255',
            'order'       => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['title']);
        $validated['order'] = $validated['order'] ?? 0;

        $group->update($validated);

        return redirect()->route('admin.assessments.index')->with('success', 'Kelompok penilaian berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $group = AssessmentGroup::findOrFail($id);

        $group->subGroups()->each(function ($sub) {
            $sub->options()->delete();
            $sub->delete();
        });

        $group->delete();

        return redirect()->route('admin.assessments.index')->with('success', 'Kelompok penilaian berhasil dihapus.');
    }

    // ─── SUB GROUPS ────────────────────────────────────────────────────

    public function createSubGroup($groupId)
    {
        $group = AssessmentGroup::findOrFail($groupId);

        return view('admin.assessments.sub_groups.form', [
            'group'      => $group,
            'subGroup'   => new AssessmentSubGroup,
        ]);
    }

    public function storeSubGroup(Request $request, $groupId)
    {
        $group = AssessmentGroup::findOrFail($groupId);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'order'       => 'nullable|integer|min:0',
        ]);

        $validated['assessment_group_id'] = $group->id;
        $validated['order'] = $validated['order'] ?? 0;

        AssessmentSubGroup::create($validated);

        return redirect()->route('admin.assessments.index')->with('success', 'Sub-kelompok berhasil ditambahkan.');
    }

    public function editSubGroup($groupId, $subGroupId)
    {
        $group = AssessmentGroup::findOrFail($groupId);
        $subGroup = AssessmentSubGroup::where('assessment_group_id', $group->id)->findOrFail($subGroupId);

        return view('admin.assessments.sub_groups.form', compact('group', 'subGroup'));
    }

    public function updateSubGroup(Request $request, $groupId, $subGroupId)
    {
        $group = AssessmentGroup::findOrFail($groupId);
        $subGroup = AssessmentSubGroup::where('assessment_group_id', $group->id)->findOrFail($subGroupId);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'order'       => 'nullable|integer|min:0',
        ]);

        $validated['order'] = $validated['order'] ?? 0;

        $subGroup->update($validated);

        return redirect()->route('admin.assessments.index')->with('success', 'Sub-kelompok berhasil diperbarui.');
    }

    public function destroySubGroup($groupId, $subGroupId)
    {
        $group = AssessmentGroup::findOrFail($groupId);
        $subGroup = AssessmentSubGroup::where('assessment_group_id', $group->id)->findOrFail($subGroupId);

        $subGroup->options()->delete();
        $subGroup->delete();

        return redirect()->route('admin.assessments.index')->with('success', 'Sub-kelompok berhasil dihapus.');
    }

    // ─── OPTIONS ───────────────────────────────────────────────────────

    public function indexOptions($groupId, $subGroupId)
    {
        $group = AssessmentGroup::findOrFail($groupId);
        $subGroup = AssessmentSubGroup::where('assessment_group_id', $group->id)->findOrFail($subGroupId);
        $options = $subGroup->options;

        return view('admin.assessments.options.index', compact('group', 'subGroup', 'options'));
    }

    public function createOption($groupId, $subGroupId)
    {
        $group = AssessmentGroup::findOrFail($groupId);
        $subGroup = AssessmentSubGroup::where('assessment_group_id', $group->id)->findOrFail($subGroupId);

        return view('admin.assessments.options.form', [
            'group'    => $group,
            'subGroup' => $subGroup,
            'option'   => new AssessmentOption,
        ]);
    }

    public function storeOption(Request $request, $groupId, $subGroupId)
    {
        $group = AssessmentGroup::findOrFail($groupId);
        $subGroup = AssessmentSubGroup::where('assessment_group_id', $group->id)->findOrFail($subGroupId);

        $validated = $request->validate([
            'text'  => 'required|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'score' => 'required|integer|min:0',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['assessment_sub_group_id'] = $subGroup->id;
        $validated['order'] = $validated['order'] ?? 0;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('assessments', 'public');
            $validated['image'] = $path;
        }

        AssessmentOption::create($validated);

        return redirect()->route('admin.assessments.options.index', [$group->id, $subGroup->id])
            ->with('success', 'Opsi penilaian berhasil ditambahkan.');
    }

    public function editOption($groupId, $subGroupId, $optionId)
    {
        $group = AssessmentGroup::findOrFail($groupId);
        $subGroup = AssessmentSubGroup::where('assessment_group_id', $group->id)->findOrFail($subGroupId);
        $option = AssessmentOption::where('assessment_sub_group_id', $subGroup->id)->findOrFail($optionId);

        return view('admin.assessments.options.form', compact('group', 'subGroup', 'option'));
    }

    public function updateOption(Request $request, $groupId, $subGroupId, $optionId)
    {
        $group = AssessmentGroup::findOrFail($groupId);
        $subGroup = AssessmentSubGroup::where('assessment_group_id', $group->id)->findOrFail($subGroupId);
        $option = AssessmentOption::where('assessment_sub_group_id', $subGroup->id)->findOrFail($optionId);

        $validated = $request->validate([
            'text'  => 'required|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'score' => 'required|integer|min:0',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['order'] = $validated['order'] ?? 0;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('assessments', 'public');
            $validated['image'] = $path;
        }

        $option->update($validated);

        return redirect()->route('admin.assessments.options.index', [$group->id, $subGroup->id])
            ->with('success', 'Opsi penilaian berhasil diperbarui.');
    }

    public function destroyOption($groupId, $subGroupId, $optionId)
    {
        $group = AssessmentGroup::findOrFail($groupId);
        $subGroup = AssessmentSubGroup::where('assessment_group_id', $group->id)->findOrFail($subGroupId);
        $option = AssessmentOption::where('assessment_sub_group_id', $subGroup->id)->findOrFail($optionId);
        $option->delete();

        return redirect()->route('admin.assessments.options.index', [$group->id, $subGroup->id])
            ->with('success', 'Opsi penilaian berhasil dihapus.');
    }

    // ─── RULES ─────────────────────────────────────────────────────────

    public function indexRules()
    {
        $rules = AssessmentRule::orderBy('order')->get();

        return view('admin.assessments.rules.index', compact('rules'));
    }

    public function createRule()
    {
        $groups = AssessmentGroup::orderBy('order')->get();

        return view('admin.assessments.rules.form', ['rule' => new AssessmentRule, 'groups' => $groups]);
    }

    public function storeRule(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'conditions'  => 'required|json',
            'result_text' => 'required|string',
            'severity'    => 'required|in:normal,ringan,sedang,tinggi',
            'order'       => 'nullable|integer|min:0',
        ]);

        $validated['order'] = $validated['order'] ?? 0;

        AssessmentRule::create($validated);

        return redirect()->route('admin.assessments.rules.index')->with('success', 'Aturan penilaian berhasil ditambahkan.');
    }

    public function editRule($id)
    {
        $rule = AssessmentRule::findOrFail($id);
        $groups = AssessmentGroup::orderBy('order')->get();

        return view('admin.assessments.rules.form', compact('rule', 'groups'));
    }

    public function updateRule(Request $request, $id)
    {
        $rule = AssessmentRule::findOrFail($id);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'conditions'  => 'required|json',
            'result_text' => 'required|string',
            'severity'    => 'required|in:normal,ringan,sedang,tinggi',
            'order'       => 'nullable|integer|min:0',
        ]);

        $validated['order'] = $validated['order'] ?? 0;

        $rule->update($validated);

        return redirect()->route('admin.assessments.rules.index')->with('success', 'Aturan penilaian berhasil diperbarui.');
    }

    public function destroyRule($id)
    {
        $rule = AssessmentRule::findOrFail($id);
        $rule->delete();

        return redirect()->route('admin.assessments.rules.index')->with('success', 'Aturan penilaian berhasil dihapus.');
    }
}
