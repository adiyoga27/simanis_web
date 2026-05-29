<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AssessmentConclusion;
use App\Models\AssessmentConclusionCondition;
use App\Models\AssessmentGroup;
use App\Models\AssessmentOption;
use App\Models\AssessmentRule;
use App\Models\AssessmentRuleCategory;
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
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'icon'        => 'nullable|string|max:255',
            'order'       => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['title']);
        $validated['order'] = $validated['order'] ?? 0;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('assessments', 'public');
        }

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
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'icon'        => 'nullable|string|max:255',
            'order'       => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['title']);
        $validated['order'] = $validated['order'] ?? 0;

        if ($request->hasFile('image')) {
            if ($group->image) {
                \Storage::disk('public')->delete($group->image);
            }
            $validated['image'] = $request->file('image')->store('assessments', 'public');
        }

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
        $categories = AssessmentRuleCategory::with('rules')->orderBy('order')->get();
        $uncategorizedRules = AssessmentRule::whereNull('rule_category_id')->orderBy('order')->get();

        return view('admin.assessments.rules.index', compact('categories', 'uncategorizedRules'));
    }

    public function createRule()
    {
        $groups = AssessmentGroup::orderBy('order')->get();
        $categories = AssessmentRuleCategory::orderBy('order')->get();

        return view('admin.assessments.rules.form', ['rule' => new AssessmentRule, 'groups' => $groups, 'categories' => $categories]);
    }

    public function storeRule(Request $request)
    {
        $validated = $request->validate([
            'rule_category_id' => 'nullable|exists:assessment_rule_categories,id',
            'title'           => 'required|string|max:255',
            'description'     => 'nullable|string',
            'score_mode'      => 'required|in:per_group,aggregate',
            'conditions'      => 'nullable|json',
            'selected_groups' => 'nullable|array',
            'result_text'     => 'nullable|string',
            'reference_link'  => 'nullable|url|max:2048',
            'color'           => 'nullable|string|max:30',
            'min_score'       => 'nullable|integer|min:0',
            'max_score'       => 'nullable|integer|min:0|gte:min_score',
            'severity'        => 'required|in:normal,ringan,sedang,tinggi',
            'order'           => 'nullable|integer|min:0',
        ]);

        if ($validated['score_mode'] === 'aggregate') {
            $validated['conditions'] = null;
            $validated['selected_groups'] = array_map('intval', $validated['selected_groups'] ?? []);
        } else {
            $validated['selected_groups'] = null;
            $validated['min_score'] = null;
            $validated['max_score'] = null;
        }

        $validated['order'] = $validated['order'] ?? 0;

        if (!empty($validated['conditions'])) {
            $validated['conditions'] = json_decode($validated['conditions'], true);
        }

        AssessmentRule::create($validated);

        return redirect()->route('admin.assessments.rules.index')->with('success', 'Aturan penilaian berhasil ditambahkan.');
    }

    public function editRule($id)
    {
        $rule = AssessmentRule::findOrFail($id);
        $groups = AssessmentGroup::orderBy('order')->get();
        $categories = AssessmentRuleCategory::orderBy('order')->get();

        return view('admin.assessments.rules.form', compact('rule', 'groups', 'categories'));
    }

    public function updateRule(Request $request, $id)
    {
        $rule = AssessmentRule::findOrFail($id);

        $validated = $request->validate([
            'rule_category_id' => 'nullable|exists:assessment_rule_categories,id',
            'title'           => 'required|string|max:255',
            'description'     => 'nullable|string',
            'score_mode'      => 'required|in:per_group,aggregate',
            'conditions'      => 'nullable|json',
            'selected_groups' => 'nullable|array',
            'result_text'     => 'nullable|string',
            'reference_link'  => 'nullable|url|max:2048',
            'color'           => 'nullable|string|max:30',
            'min_score'       => 'nullable|integer|min:0',
            'max_score'       => 'nullable|integer|min:0|gte:min_score',
            'severity'        => 'required|in:normal,ringan,sedang,tinggi',
            'order'           => 'nullable|integer|min:0',
        ]);

        if ($validated['score_mode'] === 'aggregate') {
            $validated['conditions'] = null;
            $validated['selected_groups'] = array_map('intval', $validated['selected_groups'] ?? []);
        } else {
            $validated['selected_groups'] = null;
            $validated['min_score'] = null;
            $validated['max_score'] = null;
        }

        $validated['order'] = $validated['order'] ?? 0;

        if (!empty($validated['conditions'])) {
            $validated['conditions'] = json_decode($validated['conditions'], true);
        }

        $rule->update($validated);

        return redirect()->route('admin.assessments.rules.index')->with('success', 'Aturan penilaian berhasil diperbarui.');
    }

    public function destroyRule($id)
    {
        $rule = AssessmentRule::findOrFail($id);
        $rule->delete();

        return redirect()->route('admin.assessments.rules.index')->with('success', 'Aturan penilaian berhasil dihapus.');
    }

    // ─── RULE CATEGORIES ────────────────────────────────────────────────

    public function createRuleCategory()
    {
        return view('admin.assessments.categories.form', ['category' => new AssessmentRuleCategory]);
    }

    public function storeRuleCategory(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:assessment_rule_categories,slug',
            'description' => 'nullable|string',
            'order'       => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['title']);
        $validated['order'] = $validated['order'] ?? 0;

        AssessmentRuleCategory::create($validated);

        return redirect()->route('admin.assessments.rules.index')->with('success', 'Kategori aturan berhasil ditambahkan.');
    }

    public function editRuleCategory($id)
    {
        $category = AssessmentRuleCategory::findOrFail($id);

        return view('admin.assessments.categories.form', compact('category'));
    }

    public function updateRuleCategory(Request $request, $id)
    {
        $category = AssessmentRuleCategory::findOrFail($id);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:assessment_rule_categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'order'       => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['title']);
        $validated['order'] = $validated['order'] ?? 0;

        $category->update($validated);

        return redirect()->route('admin.assessments.rules.index')->with('success', 'Kategori aturan berhasil diperbarui.');
    }

    public function destroyRuleCategory($id)
    {
        $category = AssessmentRuleCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.assessments.rules.index')->with('success', 'Kategori aturan berhasil dihapus.');
    }

    // ─── CONCLUSIONS ────────────────────────────────────────────────────

    public function indexConclusions()
    {
        $conclusions = AssessmentConclusion::with('conditions.category')->orderBy('order')->get();

        return view('admin.assessments.conclusions.index', compact('conclusions'));
    }

    public function createConclusion()
    {
        $categories = AssessmentRuleCategory::withCount('rules')->orderBy('order')->get();

        return view('admin.assessments.conclusions.form', ['conclusion' => new AssessmentConclusion, 'categories' => $categories]);
    }

    public function storeConclusion(Request $request)
    {
        $validated = $request->validate([
            'title'              => 'required|string|max:255',
            'description'        => 'nullable|string',
            'result_text'        => 'required|string',
            'reference_link'     => 'nullable|url|max:2048',
            'color'              => 'nullable|string|max:30',
            'severity'           => 'required|in:normal,ringan,sedang,tinggi',
            'priority'           => 'required|integer|min:0',
            'order'              => 'nullable|integer|min:0',
            'cond_category_id'   => 'nullable|array',
            'cond_min_matched'   => 'nullable|array',
            'cond_severity'      => 'nullable|array',
        ]);

        $validated['order'] = $validated['order'] ?? 0;

        $conclusion = AssessmentConclusion::create($validated);

        $this->syncConclusionConditions($conclusion, $request);

        return redirect()->route('admin.assessments.conclusions.index')->with('success', 'Kesimpulan berhasil ditambahkan.');
    }

    public function editConclusion($id)
    {
        $conclusion = AssessmentConclusion::with('conditions')->findOrFail($id);
        $categories = AssessmentRuleCategory::withCount('rules')->orderBy('order')->get();

        return view('admin.assessments.conclusions.form', compact('conclusion', 'categories'));
    }

    public function updateConclusion(Request $request, $id)
    {
        $conclusion = AssessmentConclusion::findOrFail($id);

        $validated = $request->validate([
            'title'              => 'required|string|max:255',
            'description'        => 'nullable|string',
            'result_text'        => 'required|string',
            'reference_link'     => 'nullable|url|max:2048',
            'color'              => 'nullable|string|max:30',
            'severity'           => 'required|in:normal,ringan,sedang,tinggi',
            'priority'           => 'required|integer|min:0',
            'order'              => 'nullable|integer|min:0',
            'cond_category_id'   => 'nullable|array',
            'cond_min_matched'   => 'nullable|array',
            'cond_severity'      => 'nullable|array',
        ]);

        $validated['order'] = $validated['order'] ?? 0;

        $conclusion->update($validated);

        $this->syncConclusionConditions($conclusion, $request);

        return redirect()->route('admin.assessments.conclusions.index')->with('success', 'Kesimpulan berhasil diperbarui.');
    }

    private function syncConclusionConditions($conclusion, $request)
    {
        $conclusion->conditions()->delete();

        $categoryIds = $request->input('cond_category_id', []);
        $minMatched = $request->input('cond_min_matched', []);
        $severities = $request->input('cond_severity', []);
        $logics = $request->input('cond_logic', []);

        foreach ($categoryIds as $index => $catId) {
            if (empty($catId)) continue;

            $conclusion->conditions()->create([
                'rule_category_id'  => $catId,
                'min_matched_rules' => max(1, (int) ($minMatched[$index] ?? 1)),
                'target_severity'   => $severities[$index] ?? null,
                'logic'             => $logics[$index] ?? 'and',
            ]);
        }
    }

    public function destroyConclusion($id)
    {
        $conclusion = AssessmentConclusion::findOrFail($id);
        $conclusion->delete();

        return redirect()->route('admin.assessments.conclusions.index')->with('success', 'Kesimpulan berhasil dihapus.');
    }
}
